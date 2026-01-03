<?php

class DatabaseErrorHelper
{
    /**
     * Get user-friendly error message for database constraint violations
     * 
     * @param Exception $e The exception from database operation
     * @param string $context The context of the operation (e.g., 'bus', 'route', 'schedule')
     * @return string User-friendly error message
     */
    public static function getConstraintErrorMessage($e, $context = '')
    {
        $errorCode = $e->getCode();
        $errorMessage = $e->getMessage();

        // Check for foreign key constraint violation (SQLSTATE 23000)
        if ($errorCode == '23000' || strpos($errorMessage, 'foreign key constraint') !== false || strpos($errorMessage, 'FOREIGN KEY') !== false) {

            // Map context to user-friendly messages
            $messages = [
                'bus' => 'Bus ini tidak dapat dihapus karena masih digunakan dalam jadwal keberangkatan. Hapus jadwal terkait terlebih dahulu.',
                'route' => 'Rute ini tidak dapat dihapus karena masih digunakan dalam jadwal keberangkatan. Hapus jadwal terkait terlebih dahulu.',
                'schedule' => 'Jadwal ini tidak dapat dihapus karena sudah memiliki pemesanan. Batalkan atau hapus pemesanan terlebih dahulu.',
                'booking' => 'Pemesanan ini tidak dapat dihapus karena sudah memiliki data pembayaran. Hapus data pembayaran terlebih dahulu.',
                'passenger' => 'Data penumpang ini tidak dapat dihapus karena masih terkait dengan pemesanan aktif.',
                'payment' => 'Data pembayaran ini tidak dapat dihapus karena masih terkait dengan data lain.',
                'user' => 'Pengguna ini tidak dapat dihapus karena memiliki data pemesanan. Hapus semua pemesanan pengguna terlebih dahulu.',
                'location' => 'Lokasi ini tidak dapat dihapus karena masih digunakan dalam rute. Hapus rute terkait terlebih dahulu.',
                'route_location' => 'Titik lokasi ini tidak dapat dihapus karena masih digunakan dalam sistem.',
                'seat' => 'Kursi ini tidak dapat dihapus karena masih digunakan dalam pemesanan.',
            ];

            if (isset($messages[$context])) {
                return $messages[$context];
            }

            // Generic message if context not found
            return 'Data ini tidak dapat dihapus karena masih digunakan oleh data lain. Hapus data terkait terlebih dahulu.';
        }

        // Check for duplicate entry violation
        if (strpos($errorMessage, 'Duplicate entry') !== false || strpos($errorMessage, 'duplicate key') !== false) {
            return 'Data yang sama sudah ada dalam sistem. Silakan gunakan data yang berbeda.';
        }

        // Check for required field violation
        if (strpos($errorMessage, 'cannot be null') !== false || strpos($errorMessage, 'NOT NULL') !== false) {
            return 'Terdapat field wajib yang belum diisi. Silakan lengkapi semua data yang diperlukan.';
        }

        // Generic database error
        return 'Terjadi kesalahan pada database. Silakan coba lagi atau hubungi administrator.';
    }

    /**
     * Handle database operation with proper error handling
     * 
     * @param callable $operation The database operation to execute
     * @param string $context The context for error message
     * @param string $successUrl Redirect URL on success
     * @param string $errorUrl Redirect URL on error
     * @param string $successMessage Success message
     * @return bool Whether operation was successful
     */
    public static function handleDatabaseOperation($operation, $context, $successUrl, $errorUrl, $successMessage = 'Operasi berhasil')
    {
        try {
            $result = $operation();

            if ($result) {
                $_SESSION['success'] = $successMessage;
                header('Location: ' . $successUrl);
                exit;
            } else {
                $_SESSION['error'] = 'Operasi gagal. Silakan coba lagi.';
                header('Location: ' . $errorUrl);
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = self::getConstraintErrorMessage($e, $context);
            header('Location: ' . $errorUrl);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = self::getConstraintErrorMessage($e, $context);
            header('Location: ' . $errorUrl);
            exit;
        }
    }

    /**
     * Check if error is a constraint violation
     * 
     * @param Exception $e The exception to check
     * @return bool Whether it's a constraint violation
     */
    public static function isConstraintViolation($e)
    {
        $errorCode = $e->getCode();
        $errorMessage = $e->getMessage();

        return ($errorCode == '23000' ||
            strpos($errorMessage, 'foreign key constraint') !== false ||
            strpos($errorMessage, 'FOREIGN KEY') !== false ||
            strpos($errorMessage, 'constraint fails') !== false);
    }
}
