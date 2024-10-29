<?php

class BillRepository {
    private $filePath = __DIR__ . '/../data/bills.json';

    public function __construct() {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function getAllBills() {
        $bills = json_decode(file_get_contents($this->filePath), true);
        return $bills ?: [];
    }

    public function getBillById($id) {
        $bills = $this->getAllBills();
        foreach ($bills as $bill) {
            if ($bill['id'] === $id) {
                return $bill;
            }
        }
        return null;
    }

    public function saveBill($bill) {
        $bills = $this->getAllBills();
        $bills[] = $bill;
        file_put_contents($this->filePath, json_encode($bills));
    }

    public function updateBill($updatedBill) {
        $bills = $this->getAllBills();
        foreach ($bills as $index => $bill) {
            if ($bill['id'] === $updatedBill['id']) {
                $bills[$index] = $updatedBill;
                break;
            }
        }
        file_put_contents($this->filePath, json_encode($bills));
    }
}
?>
