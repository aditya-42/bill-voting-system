<?php
require_once __DIR__ . '/../repositories/BillRepository.php';

class BillController {
    private $billRepo;

    public function __construct() {
        $this->billRepo = new BillRepository();
    }

    public function createBill($title, $description, $author) {
        $bill = [
            'id' => uniqid(),
            'title' => $title,
            'description' => $description,
            'author' => $author,
            'status' => 'Draft',
            'created_at' => date('Y-m-d H:i:s'),
            'amendments' => [],
            'votes' => ['for' => 0, 'against' => 0, 'abstain' => 0],
            'versions' => []
        ];
        $this->billRepo->saveBill($bill);
        return $bill;
    }

    public function getAllBills() {
        return $this->billRepo->getAllBills();
    }

    public function getBillById($id) {
        return $this->billRepo->getBillById($id);
    }

    public function editBill($billId, $title, $description, $author) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill) {
            $bill['versions'][] = [
                'title' => $bill['title'],
                'description' => $bill['description'],
                'timestamp' => date('Y-m-d\TH:i:s'),
                'author' => $author
            ];
            $bill['title'] = $title;
            $bill['description'] = $description;
            $this->billRepo->updateBill($bill);
        }
    }

    public function addAmendment($billId, $amendment) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill) {
            $bill['amendments'][] = $amendment;
            $this->billRepo->updateBill($bill);
        }
    }

    public function getBillsWithPendingAmendments() {
        $bills = $this->billRepo->getAllBills();
        return array_filter($bills, function($bill) {
            return !empty(array_filter($bill['amendments'], function($amendment) {
                return $amendment['status'] === 'Pending';
            }));
        });
    }

    public function submitForReview($billId) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill) {
            $bill['status'] = 'under review';
            $this->billRepo->updateBill($bill);
        }
    }

    public function approveBill($billId) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill) {
            $bill['status'] = 'approved';
            $this->billRepo->updateBill($bill);
        }
    }

    public function rejectBill($billId) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill) {
            $bill['status'] = 'rejected';
            $this->billRepo->updateBill($bill);
        }
    }

    public function getBillsByStatus($status) {
        return $this->billRepo->getBillsByStatus($status);
    }

    public function initiateVoting($billId) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill && $bill['status'] === 'approved') {
            $bill['status'] = 'voting';
            $bill['votes'] = ['for' => 0, 'against' => 0, 'abstain' => 0];
            $this->billRepo->updateBill($bill);
        }
    }

    public function recordVote($billId, $vote) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill && $bill['status'] === 'voting') {
            $bill['votes'][$vote]++;
            $this->billRepo->updateBill($bill);
        }
    }

    public function updateBillStatus($billId, $status) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill && $bill['status'] === 'voting') {
            $bill['status'] = $status;
            $this->billRepo->updateBill($bill);
        }
    }

    public function calculateVoteResults($billId) {
        $bill = $this->billRepo->getBillById($billId);
        if ($bill) {
            $results = [
                'For' => $bill['votes']['for'] ?? 0,
                'Against' => $bill['votes']['against'] ?? 0,
                'Abstain' => $bill['votes']['abstain'] ?? 0,
                'status' => ''
            ];

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

            $this->billRepo->updateBill($bill);
            return $results;
        }
        return null;
    }
}
?>