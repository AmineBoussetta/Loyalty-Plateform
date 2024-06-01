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

                $name = $cells[0]->getValue();
                $email = $cells[1]->getValue();
                $phone = $cells[2]->getValue();
                $moneySpent = $cells[3]->getValue();

                // Replace comma with period for decimal values, if any
                $moneySpent = str_replace(',', '.', $moneySpent);

                // Validate that moneySpent is numeric
                if (is_numeric($moneySpent)) {
                    Client::create([
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'money_spent' => $moneySpent,
                    ]);
                } else {
                    // Log the invalid value for debugging
                    error_log("Invalid money_spent value: $moneySpent for client: $name");
                }
            }
        }

        $reader->close();
    }
}
