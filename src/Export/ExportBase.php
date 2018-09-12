<?php
namespace Laravolt\Suitable\Export;
use Carbon\Carbon;

abstract class ExportBase {

    protected $title = null;

    protected $data;

    protected function __construct($data)
    {
        $this->data       = $data;
        $this->setTitle();
    }

    protected function setTitle(): void
    {
        $title = $this->data['title'];
        $randomTime = Carbon::now()->format('YmdHis');
        $this->title = $title ? $title .'_'. $randomTime : $randomTime;
    }

    abstract protected function export(): void;
}