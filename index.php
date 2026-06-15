<?php
require 'config.php';
$stmt = $conn->query("SELECT * FROM cars WHERE is_parked = TRUE ORDER BY entry_date DESC, entry_time DESC");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalCars = count($cars);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автостоянка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <h1>Автостоянка</h1>
        
        <div class="form-section">
            <h2>Заезд автомобиля</h2>
            <form method="POST" action="actions.php">
                <div class="form-grid">
                    <div class="input-group">
                        <label>Марка</label>
                        <input type="text" name="brand" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Владелец</label>
                        <input type="text" name="owner_name" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Телефон</label>
                        <input type="text" name="owner_phone" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Госномер</label>
                        <input type="text" name="license_plate" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Дата въезда</label>
                        <input type="date" name="entry_date" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Время въезда</label>
                        <input type="time" name="entry_time" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Цена (₽/час)</label>
                        <input type="number" step="1" name="hourly_rate" value="100">
                    </div>
                    
                    <div class="input-group">
                        <label>Долг (₽)</label>
                        <input type="number" step="1" name="debt" value="0">
                    </div>
                </div>
                <button type="submit" name="add_car">+ Добавить</button>
            </form>
        </div>

        <h2>На стоянке (<?= $totalCars ?>)</h2>

        <?php if ($totalCars > 0): ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Марка</th>
                        <th>Владелец</th>
                        <th>Телефон</th>
                        <th>Госномер</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Ставка</th>
                        <th>Долг</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): 
                        $has_debt = $car['debt'] > 0;
                    ?>
                    <tr class="<?= $has_debt ? 'has-debt' : '' ?>">
                        <td><?= htmlspecialchars($car['brand']) ?></td>
                        <td><?= htmlspecialchars($car['owner_name']) ?></td>
                        <td><?= htmlspecialchars($car['owner_phone']) ?></td>
                        <td><?= htmlspecialchars($car['license_plate']) ?></td>
                        <td><?= $car['entry_date'] ?></td>
                        <td><?= $car['entry_time'] ?></td>
                        <td><?= $car['hourly_rate'] ?> ₽</td>
                        <td class="<?= $has_debt ? 'debt-positive' : '' ?>">
                            <?php if ($has_debt): ?>
                                <strong><?= $car['debt'] ?> ₽</strong>
                            <?php else: ?>
                                <?= $car['debt'] ?> ₽
                            <?php endif; ?>
                         </td>
                        <td>
                            <form method="POST" action="actions.php" style="display: inline-block;">
                                <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                <input type="number" step="1" name="debt" value="<?= $car['debt'] ?>" style="width: 80px;">
                                <button type="submit" name="update_debt">Обновить</button>
                            </form>
                            
                            <?php if ($has_debt): ?>
                                <button class="btn-exit-disabled" disabled>Выезд запрещён</button>
                            <?php else: ?>
                                <a href="actions.php?exit=<?= $car['id'] ?>" class="btn-exit" onclick="return confirm('Выезд?')">Выезд</a>
                            <?php endif; ?>
                         </td>
                     </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>На стоянке нет машин</p>
        <?php endif; ?>
</body>
</html>