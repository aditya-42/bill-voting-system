<?php
require_once __DIR__ . '/../repositories/BillRepository.php';

class BillController {
    private $billRepo;

    public function __construct() {
        $this->billRepo = new BillRepository();
        $this->billRepo = new BillRepository(); $this->billsFile = __DIR__ . '/../data/bills.json';
    }

    public function createBill($title, $description, $author) {
        $bill = [
            'id' => uniqid(),
            'title' => $title,
            'description' => $description,
            'author' => $author,
            'status' => 'Draft',
            'created_at' => date('Y-m-d H:i:s'),
            'amendments' => []
        ];
        $this->billRepo->saveBill($bill);
        return $bill;
    }

    public function getAllBills() {
        return $this->billRepo->getAllBills();
    }

    public function getBill($id) {
        return $this->billRepo->getBillById($id);
    }

    public function editBill($billId, $title, $description, $author) {
        $bills = $this->getAllBills();
        foreach ($bills as &$bill) {
            if ($bill['id'] == $billId) {
                $bill['versions'][] = [
                    'title' => $bill['title'],
                    'description' => $bill['description'],
                    'timestamp' => date('Y-m-d\TH:i:s'),
                    'author' => $author
                ];

                $bill['title'] = $title;
                $bill['description'] = $description;
                break;
            }
        }
        file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
    }

    public function addAmendment($billId, $amendment) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId) {
            $bill['amendments'][] = $amendment;
            break;
        }
    }
        file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
    }

    public function getBillsWithPendingAmendments() {
        $bills = $this->getAllBills();
        $pendingAmendments = [];

        foreach ($bills as $bill) {
            foreach ($bill['amendments'] as $amendment) {
                if ($amendment['status'] === 'Pending') {
                    $pendingAmendments[] = $bill;
                    break;
                }
            }
        }

        return $pendingAmendments;
    }

     public function getBillById($id) {
        $bills = $this->getAllBills();
        foreach ($bills as $bill) {
            if ($bill['id'] == $id) {
                return $bill;
            }
        }
        return null;
    }

    public function submitForReview($billId) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId) {
            $bill['status'] = 'under review';
            break;
        }
    }
    file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
    }

    public function approveBill($billId) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId) {
            $bill['status'] = 'approved';
            break;
        }
    }
    file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
    }   

    public function rejectBill($billId) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId) {
            $bill['status'] = 'rejected';
            break;
        }
    }
    file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
    }

    public function getBillsByStatus($status) {
    $bills = $this->getAllBills();
    return array_filter($bills, function($bill) use ($status) {
        return $bill['status'] === $status;
    });
}
    public function initiateVoting($billId) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId && $bill['status'] === 'approved') {
            $bill['status'] = 'voting';
            $bill['votes'] = ['for' => 0, 'against' => 0, 'abstain' => 0];
            break;
        }
    }
    file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
}

public function recordVote($billId, $vote) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId && $bill['status'] === 'voting') {
            $bill['votes'][$vote]++;
            break;
        }
    }
    file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
}

public function updateBillStatus($billId, $status) {
    $bills = $this->getAllBills();
    foreach ($bills as &$bill) {
        if ($bill['id'] == $billId && $bill['status'] === 'voting') {
            $bill['status'] = $status;
            break;
        }
    }
    file_put_contents($this->billsFile, json_encode($bills, JSON_PRETTY_PRINT));
}


public function calculateVoteResults($billId) {
    $bills = $this->getAllBills();
    $results = ['For' => 0, 'Against' => 0, 'Abstain' => 0, 'status' => ''];

    foreach ($bills as $bill) {
        if ($bill['id'] === $billId) {
            $results['For'] = $bill['votes']['for'] ?? 0;
            $results['Against'] = $bill['votes']['against'] ?? 0;
            $results['Abstain'] = $bill['votes']['abstain'] ?? 0;

            if ($results['For'] > $results['Against']) {
                $results['status'] = 'Passed';
                $bill['status'] = 'Passed';
            } elseif ($results['Against'] >= $results['For']) {
                $results['status'] = 'Rejected';
                $bill['status'] = 'Rejected';
            } else {
                $results['status'] = 'Pending';
                $bill['status'] = 'Pending';
            }

            return $results;
        }
    }
    return null;
}


}
?>
