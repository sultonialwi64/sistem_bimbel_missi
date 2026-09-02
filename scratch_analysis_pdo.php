<?php
$dsn = 'mysql:host=127.0.0.1;port=3307;dbname=sistem_bimbel';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get total discounts for payments in August/September
    $stmt = $pdo->query("SELECT sum(discount) as total_discount FROM payments WHERE due_date BETWEEN '2026-08-01' AND '2026-09-30'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total Discount (Aug-Sep): Rp " . number_format($row['total_discount'], 0, ',', '.') . "\n";

    // Let's get total bonus and deductions
    $stmt = $pdo->query("SELECT sum(bonus) as total_bonus, sum(deduction) as total_deduction FROM salaries WHERE period_start BETWEEN '2026-08-01' AND '2026-08-31'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total Bonus: Rp " . number_format($row['total_bonus'], 0, ',', '.') . "\n";
    echo "Total Deduction: Rp " . number_format($row['total_deduction'], 0, ',', '.') . "\n";

    // Let's also get the sum of discounts for all time just in case
    $stmt = $pdo->query("SELECT sum(discount) as total_discount FROM payments");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total Discount (All Time): Rp " . number_format($row['total_discount'], 0, ',', '.') . "\n";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
