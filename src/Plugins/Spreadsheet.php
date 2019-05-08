<?php

namespace Laravolt\Suitable\Plugins;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Laravolt\Suitable\Builder;
use Laravolt\Suitable\Concerns\SourceOverridden;
use Laravolt\Suitable\Toolbars\Action;

class Spreadsheet extends Plugin implements \Laravolt\Suitable\Contracts\Plugin
{
    use SourceOverridden;

    protected $shouldResponse = false;

    protected $filename = 'spreadsheet.csv';

    protected $format = null;

    /**
     * Spreadsheet constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->format = array_get(pathinfo($this->filename), 'extension', 'csv');
    }

    public function init()
    {
        $this->shouldResponse = request('format') === $this->format;
    }

    public function shouldResponse(): bool
    {
        return $this->shouldResponse;
    }

    public function decorate(Builder $table): Builder {
        $url = request()->url().'?'.http_build_query(array_merge(request()->input(), ['format' => $this->format]));

        $segment = $table->getDefaultSegment();
        $segment->addLeft(Action::make('Export To '.title_case($this->format), $url));

        return $table;
    }

    public function resolve($source)
    {
        if ($source instanceof LengthAwarePaginator) {
            return $source->items();
        }

        return parent::resolve($source);
    }

    public function response($source, Builder $table)
    {
        $source = $this->overriddenSource ?? $this->resolve($source);

        if (count($this->only) > 0) {
            $source = $source->map->only($this->only);
        }

        switch ($this->format) {
            case 'xls':
            case 'xlsx':

                return fastexcel($source)->download($this->filename);
                break;

            case 'csv':
            default:

                return fastexcel($source)->configureCsv(';', '#', '\n', 'gbk')->download($this->filename);
        }
    }
}
