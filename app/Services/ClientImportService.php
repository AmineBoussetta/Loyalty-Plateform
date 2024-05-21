<?php
namespace App\Services;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Client;

class ClientImportService
{
    public function import($filePath)
    {
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();

                Client::create([
                    'name' => $cells[0]->getValue(),
                    'email' => $cells[1]->getValue(),
                    'phone' => $cells[2]->getValue(), // Include phone field
                ]);
            }
        }

        $reader->close();
    }
}
