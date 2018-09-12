<?php
namespace Laravolt\Suitable\Export;
use Rap2hpoutre\FastExcel\FastExcel;

class Excel extends ExportBase{

    private $type;

    public function __construct($data, $type = 'xlsx')
    {
        parent::__construct($data);
        $this->type = $type;
        $this->export();
    }

    public function export(): void
    {
        (new FastExcel($this->data['collection']))->download($this->title . '.' . $this->type);
    }
}