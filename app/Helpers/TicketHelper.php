<?php

require_once __DIR__ . '/../../vendor/autoload.php';

class TicketHelper
{
    /**
     * Generate e-ticket PDF for booking
     * 
     * @param array $booking Booking data with all details
     * @param array $passengers Array of passengers
     * @param array $payment Payment data
     * @return string Path to generated PDF file
     */
    public static function generateTicketPDF($booking, $passengers, $payment)
    {
        // Create new PDF document
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Sinar Jaya Transport');
        $pdf->SetAuthor('Sinar Jaya');
        $pdf->SetTitle('E-Ticket - ' . $booking['booking_code']);
        $pdf->SetSubject('E-Ticket Bus');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 15);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 10);

        // Build HTML content
        $html = self::buildTicketHTML($booking, $passengers, $payment);

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Generate QR Code
        $qrContent = "BOOKING:{$booking['booking_code']}\nTOTAL:{$booking['total_passengers']}\nROUTE:{$booking['origin_city']}-{$booking['destination_city']}\nDATE:" . date('Y-m-d', strtotime($booking['departure_datetime']));

        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => array(255, 255, 255),
            'module_width' => 1,
            'module_height' => 1
        );

        // QR code position (top right) - adjusted to avoid border overlap
        $pdf->write2DBarcode($qrContent, 'QRCODE,H', 155, 22, 32, 32, $style, 'N');

        // Create directory if not exists
        $uploadDir = __DIR__ . '/../../public/uploads/tickets/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate filename
        $filename = 'TICKET_' . $booking['booking_code'] . '_' . date('YmdHis') . '.pdf';
        $filepath = $uploadDir . $filename;

        // Output PDF to file
        $pdf->Output($filepath, 'F');

        return $filename;
    }

    /**
     * Build HTML content for ticket
     */
    private static function buildTicketHTML($booking, $passengers, $payment)
    {
        $departureDate = date('d M Y', strtotime($booking['departure_datetime']));
        $departureTime = date('H:i', strtotime($booking['departure_datetime']));

        $paymentStatus = $payment && $payment['payment_status'] === 'paid' ? 'LUNAS' : 'BELUM LUNAS';
        $statusColor = $payment && $payment['payment_status'] === 'paid' ? '#10b981' : '#ef4444';

        $html = '
        <style>
            body { font-family: Arial, sans-serif; }
            .ticket {
                border: 2px solid #333;
                padding: 15px;
                max-width: 100%;
            }
            .header {
                text-align: center;
                border-bottom: 2px solid #333;
                padding-bottom: 10px;
                margin-bottom: 15px;
            }
            .company { font-size: 20px; font-weight: bold; }
            .booking-code {
                text-align: center;
                font-size: 16px;
                font-weight: bold;
                background: #f0f0f0;
                padding: 8px;
                margin: 10px 0;
            }
            .route {
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                margin: 15px 0;
            }
            table { width: 100%; border-collapse: collapse; margin: 10px 0; }
            td { padding: 5px 0; font-size: 11px; }
            td:first-child { width: 35%; color: #666; }
            td:last-child { font-weight: bold; }
            .section { margin: 15px 0; border-top: 1px solid #ddd; padding-top: 10px; }
            .section-title { font-weight: bold; font-size: 12px; margin-bottom: 8px; }
            .passenger { 
                background: #f9f9f9; 
                padding: 8px; 
                margin: 5px 0; 
                font-size: 11px;
                border-left: 3px solid #333;
            }
            .passenger-name { font-weight: bold; font-size: 12px; }
            .total {
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                background: #f0f0f0;
                padding: 10px;
                margin: 15px 0;
            }
            .footer {
                border-top: 1px dashed #999;
                padding-top: 10px;
                margin-top: 15px;
                font-size: 9px;
                color: #666;
                text-align: center;
            }
        </style>

        <div class="ticket">
            <div class="header">
                <div class="company">SINAR JAYA TRANSPORT</div>
                <div style="font-size: 14px;">E-Ticket Bus</div>
            </div>

            <div class="booking-code">' . htmlspecialchars($booking['booking_code']) . '</div>

            <div class="route">
                ' . htmlspecialchars($booking['origin_city']) . ' → ' . htmlspecialchars($booking['destination_city']) . '
            </div>

            <table>
                <tr>
                    <td>Tanggal</td>
                    <td>' . $departureDate . '</td>
                </tr>
                <tr>
                    <td>Jam Berangkat</td>
                    <td>' . $departureTime . ' WIB</td>
                </tr>
                <tr>
                    <td>Kelas Bus</td>
                    <td>' . htmlspecialchars($booking['bus_class_name'] ?? 'Standard') . '</td>
                </tr>
                <tr>
                    <td>Titik Naik</td>
                    <td>' . htmlspecialchars($booking['pickup_location_name'] ?? $booking['origin_city']) . '</td>
                </tr>
                <tr>
                    <td>Titik Turun</td>
                    <td>' . htmlspecialchars($booking['drop_location_name'] ?? $booking['destination_city']) . '</td>
                </tr>
            </table>

            <div class="section">
                <div class="section-title">PENUMPANG (' . count($passengers) . ' orang)</div>';

        foreach ($passengers as $index => $passenger) {
            $seatNumber = isset($passenger['seat_number']) ? $passenger['seat_number'] : '-';
            $html .= '
                <div class="passenger">
                    <div class="passenger-name">' . ($index + 1) . '. ' . htmlspecialchars($passenger['full_name']) . '</div>
                    <div>Kursi: ' . htmlspecialchars($seatNumber) . '</div>
                </div>';
        }

        $html .= '
            </div>

            <table style="margin-top: 15px;">
                <tr>
                    <td>Status</td>
                    <td style="color: ' . $statusColor . ';">' . $paymentStatus . '</td>
                </tr>
            </table>

            <div class="total">
                TOTAL: Rp ' . number_format($booking['total_amount'], 0, ',', '.') . '
            </div>

            <div class="footer">
                Tunjukkan e-ticket ini saat boarding<br>
                Harap tiba 30 menit sebelum keberangkatan<br>
                Info: 0800-1234-5678
            </div>
        </div>';

        return $html;
    }

    /**
     * Format payment method name
     */
    private static function formatPaymentMethod($method)
    {
        $methods = [
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'qris' => 'QRIS',
            'cash' => 'Tunai'
        ];

        return $methods[$method] ?? ucfirst(str_replace('_', ' ', $method));
    }

    /**
     * Get ticket file path
     */
    public static function getTicketPath($filename)
    {
        return __DIR__ . '/../../public/uploads/tickets/' . $filename;
    }

    /**
     * Get ticket URL
     */
    public static function getTicketURL($filename)
    {
        return BASEURL . 'uploads/tickets/' . $filename;
    }
}
