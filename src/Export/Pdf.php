<?php
namespace Laravolt\Suitable\Export;
use niklasravnsborg\LaravelPdf\Facades\Pdf as ExportPdf;

class Pdf extends ExportBase {

    public function __construct($data)
    {
        parent::__construct($data);
        $this->export();
    }

    public function export(): void
    {
        $data = $this->data;
        $pdf = ExportPdf::loadView('suitable::exports.pdf', $data);
        $pdf->download($this->title . '.pdf');
    }
}