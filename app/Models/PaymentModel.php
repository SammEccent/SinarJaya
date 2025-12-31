<?php

class PaymentModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get all payments with booking details
     */
    public function getAll($limit = null, $offset = 0)
    {
        $query = 'SELECT 
                    p.id, 
                    p.booking_id, 
                    p.payment_method, 
                    p.payment_code, 
                    p.amount, 
                    p.payment_status, 
                    p.payment_proof_image,
                    p.paid_at,
                    p.created_at,
                    p.updated_at,
                    b.booking_code,
                    b.user_id,
                    b.total_amount,
                    b.booking_status,
                    u.name,
                    u.email,
                    u.phone
                FROM payments p
                JOIN bookings b ON p.booking_id = b.id
                JOIN users u ON b.user_id = u.id
                ORDER BY p.created_at DESC';

        if ($limit !== null) {
            $query .= ' LIMIT ' . intval($limit) . ' OFFSET ' . intval($offset);
        }

        $this->db->prepare($query);
        return $this->db->fetchAll();
    }

    /**
     * Get total count of payments
     */
    public function count()
    {
        $this->db->prepare('SELECT COUNT(*) as total FROM payments');
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Get payment by ID
     */
    public function findById($id)
    {
        $this->db->prepare('
            SELECT 
                p.id, 
                p.booking_id, 
                p.payment_method, 
                p.payment_code, 
                p.amount, 
                p.payment_status, 
                p.payment_proof_image,
                p.paid_at,
                p.payment_details,
                p.created_at,
                p.updated_at,
                b.booking_code,
                b.user_id,
                b.schedule_id,
                b.total_passengers,
                b.total_amount,
                b.booking_status,
                b.payment_expiry,
                u.name,
                u.email,
                u.phone,
                s.departure_datetime,
                s.arrival_datetime,
                r.origin_city,
                r.destination_city
            FROM payments p
            JOIN bookings b ON p.booking_id = b.id
            JOIN users u ON b.user_id = u.id
            JOIN schedules s ON b.schedule_id = s.id
            JOIN routes r ON s.route_id = r.route_id
            WHERE p.id = :id
            LIMIT 1
        ');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    /**
     * Get payment by booking ID
     */
    public function getByBookingId($booking_id)
    {
        $this->db->prepare('
            SELECT 
                p.*,
                b.booking_code,
                b.total_amount
            FROM payments p
            JOIN bookings b ON p.booking_id = b.id
            WHERE p.booking_id = :booking_id
            ORDER BY p.created_at DESC
            LIMIT 1
        ');
        $this->db->bind(':booking_id', $booking_id);
        return $this->db->fetch();
    }

    /**
     * Get payments by status
     */
    public function getByStatus($status, $limit = null, $offset = 0)
    {
        $query = 'SELECT 
                    p.id, 
                    p.booking_id, 
                    p.payment_method, 
                    p.payment_code, 
                    p.amount, 
                    p.payment_status, 
                    p.payment_proof_image,
                    p.paid_at,
                    p.created_at,
                    b.booking_code,
                    b.user_id,
                    u.name,
                    u.email
                FROM payments p
                JOIN bookings b ON p.booking_id = b.id
                JOIN users u ON b.user_id = u.id
                WHERE p.payment_status = :status
                ORDER BY p.created_at DESC';

        if ($limit !== null) {
            $query .= ' LIMIT ' . intval($limit) . ' OFFSET ' . intval($offset);
        }

        $this->db->prepare($query);
        $this->db->bind(':status', $status);
        return $this->db->fetchAll();
    }

    /**
     * Count payments by status
     */
    public function countByStatus($status)
    {
        $this->db->prepare('SELECT COUNT(*) as total FROM payments WHERE payment_status = :status');
        $this->db->bind(':status', $status);
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Get payment statistics
     */
    public function getStatistics()
    {
        $this->db->prepare('
            SELECT 
                COUNT(*) as total_payments,
                SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid_payments,
                SUM(CASE WHEN payment_status = "pending" THEN 1 ELSE 0 END) as pending_payments,
                SUM(CASE WHEN payment_status = "failed" THEN 1 ELSE 0 END) as failed_payments,
                SUM(CASE WHEN payment_status = "refunded" THEN 1 ELSE 0 END) as refunded_payments,
                SUM(CASE WHEN payment_status = "paid" THEN amount ELSE 0 END) as total_revenue,
                AVG(amount) as average_payment
            FROM payments
        ');
        return $this->db->fetch();
    }

    /**
     * Create new payment
     */
    public function create($data)
    {
        $this->db->prepare('
            INSERT INTO payments 
            (booking_id, payment_method, payment_code, amount, payment_status, payment_proof_image, payment_details, created_at, updated_at) 
            VALUES 
            (:booking_id, :payment_method, :payment_code, :amount, :payment_status, :payment_proof_image, :payment_details, :created_at, :updated_at)
        ');
        $this->db->bind(':booking_id', $data['booking_id']);
        $this->db->bind(':payment_method', $data['payment_method']);
        $this->db->bind(':payment_code', $data['payment_code'] ?? null);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':payment_status', $data['payment_status'] ?? 'pending');
        $this->db->bind(':payment_proof_image', $data['payment_proof_image'] ?? null);
        $this->db->bind(':payment_details', isset($data['payment_details']) ? json_encode($data['payment_details']) : null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    /**
     * Update payment
     */
    public function update($id, $data)
    {
        $updates = [];
        $bindings = [':id' => $id];

        if (isset($data['payment_method'])) {
            $updates[] = 'payment_method = :payment_method';
            $bindings[':payment_method'] = $data['payment_method'];
        }
        if (isset($data['payment_code'])) {
            $updates[] = 'payment_code = :payment_code';
            $bindings[':payment_code'] = $data['payment_code'];
        }
        if (isset($data['amount'])) {
            $updates[] = 'amount = :amount';
            $bindings[':amount'] = $data['amount'];
        }
        if (isset($data['payment_status'])) {
            $updates[] = 'payment_status = :payment_status';
            $bindings[':payment_status'] = $data['payment_status'];
        }
        if (isset($data['payment_proof_image'])) {
            $updates[] = 'payment_proof_image = :payment_proof_image';
            $bindings[':payment_proof_image'] = $data['payment_proof_image'];
        }
        if (isset($data['paid_at'])) {
            $updates[] = 'paid_at = :paid_at';
            $bindings[':paid_at'] = $data['paid_at'];
        }
        if (isset($data['payment_details'])) {
            $updates[] = 'payment_details = :payment_details';
            $bindings[':payment_details'] = json_encode($data['payment_details']);
        }

        if (empty($updates)) {
            return false;
        }

        $updates[] = 'updated_at = :updated_at';
        $bindings[':updated_at'] = date('Y-m-d H:i:s');

        $query = 'UPDATE payments SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $this->db->prepare($query);

        foreach ($bindings as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->execute();
    }

    /**
     * Approve/Confirm payment
     */
    public function approvePayment($id, $paid_at = null)
    {
        if ($paid_at === null) {
            $paid_at = date('Y-m-d H:i:s');
        }

        $this->db->prepare('
            UPDATE payments 
            SET payment_status = "paid", paid_at = :paid_at, updated_at = :updated_at
            WHERE id = :id
        ');
        $this->db->bind(':id', $id);
        $this->db->bind(':paid_at', $paid_at);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    /**
     * Reject payment
     */
    public function rejectPayment($id, $reason = null)
    {
        $query = 'UPDATE payments SET payment_status = "failed", updated_at = :updated_at';
        if ($reason !== null) {
            $query .= ', payment_details = JSON_SET(payment_details, "$.rejection_reason", :reason)';
        }
        $query .= ' WHERE id = :id';

        $this->db->prepare($query);
        $this->db->bind(':id', $id);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        if ($reason !== null) {
            $this->db->bind(':reason', $reason);
        }
        return $this->db->execute();
    }

    /**
     * Refund payment
     */
    public function refundPayment($id, $reason = null)
    {
        $query = 'UPDATE payments SET payment_status = "refunded", updated_at = :updated_at';
        if ($reason !== null) {
            $query .= ', payment_details = JSON_SET(payment_details, "$.refund_reason", :reason)';
        }
        $query .= ' WHERE id = :id';

        $this->db->prepare($query);
        $this->db->bind(':id', $id);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        if ($reason !== null) {
            $this->db->bind(':reason', $reason);
        }
        return $this->db->execute();
    }

    /**
     * Delete payment
     */
    public function delete($id)
    {
        $this->db->prepare('DELETE FROM payments WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Search payments by booking code or user
     */
    public function search($keyword)
    {
        $this->db->prepare('
            SELECT 
                p.*,
                b.booking_code,
                u.name,
                u.email
            FROM payments p
            JOIN bookings b ON p.booking_id = b.id
            JOIN users u ON b.user_id = u.id
            WHERE b.booking_code LIKE :keyword 
                OR u.name LIKE :keyword 
                OR u.email LIKE :keyword
                OR p.payment_code LIKE :keyword
            ORDER BY p.created_at DESC
        ');
        $keyword = '%' . $keyword . '%';
        $this->db->bind(':keyword', $keyword);
        return $this->db->fetchAll();
    }
}
