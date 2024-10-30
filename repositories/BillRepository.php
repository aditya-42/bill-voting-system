<?php
require_once __DIR__ . '/../config/db.php';

class BillRepository {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->db->connect_error) {
            throw new Exception("Connection failed: " . $this->db->connect_error);
        }
    }

    public function saveBill($bill) {
        $stmt = $this->db->prepare("INSERT INTO bills (id, title, description, author, status, created_at, amendments, votes, versions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $amendments = json_encode($bill['amendments'] ?? []);
        $votes = json_encode($bill['votes'] ?? []);
        $versions = json_encode($bill['versions'] ?? []);
        $stmt->bind_param("sssssssss", $bill['id'], $bill['title'], $bill['description'], $bill['author'], $bill['status'], $bill['created_at'], $amendments, $votes, $versions);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllBills() {
        $result = $this->db->query("SELECT * FROM bills");
        $bills = [];
        while ($row = $result->fetch_assoc()) {
            $row['amendments'] = json_decode($row['amendments'], true);
            $row['votes'] = json_decode($row['votes'], true);
            $row['versions'] = json_decode($row['versions'], true);
            $bills[] = $row;
        }
        return $bills;
    }

    public function getBillById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bills WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bill = $result->fetch_assoc();
        if ($bill) {
            $bill['amendments'] = json_decode($bill['amendments'], true);
            $bill['votes'] = json_decode($bill['votes'], true);
            $bill['versions'] = json_decode($bill['versions'], true);
        }
        $stmt->close();
        return $bill;
    }

    public function updateBill($bill) {
        $stmt = $this->db->prepare("UPDATE bills SET title = ?, description = ?, author = ?, status = ?, amendments = ?, votes = ?, versions = ? WHERE id = ?");
        $amendments = json_encode($bill['amendments']);
        $votes = json_encode($bill['votes']);
        $versions = json_encode($bill['versions']);
        $stmt->bind_param("ssssssss", $bill['title'], $bill['description'], $bill['author'], $bill['status'], $amendments, $votes, $versions, $bill['id']);
        $stmt->execute();
        $stmt->close();
    }

    public function getBillsByStatus($status) {
        $stmt = $this->db->prepare("SELECT * FROM bills WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $bills = [];
        while ($row = $result->fetch_assoc()) {
            $row['amendments'] = json_decode($row['amendments'], true);
            $row['votes'] = json_decode($row['votes'], true);
            $row['versions'] = json_decode($row['versions'], true);
            $bills[] = $row;
        }
        $stmt->close();
        return $bills;
    }
}
?>