<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Grocery Planner</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    $weeks = [
        [
            'name' => 'Week 1',
            'emoji' => '📅', // Calendar emoji for Week 1
            'description' => 'Regular family meals',
            'items' => [
                'Meat' => [
                    ['name' => 'Chicken Breast', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🍗'],
                    ['name' => 'Ground Beef', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🥩'],
                    ['name' => 'Pork Chops', 'quantity' => '1.5 lbs', 'bought' => false, 'emoji' => '🐖']
                ],
                'Vegetables' => [
                    ['name' => 'Broccoli', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🥦'],
                    ['name' => 'Carrots', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🥕'],
                    ['name' => 'Onions', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🧅']
                ],
                'Dairy' => [
                    ['name' => 'Milk', 'quantity' => '1 gallon', 'bought' => false, 'emoji' => '🥛'],
                    ['name' => 'Cheese (Cheddar)', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🧀'],
                    ['name' => 'Eggs', 'quantity' => '1 dozen', 'bought' => false, 'emoji' => '🥚']
                ],
                'Fruits' => [
                    ['name' => 'Apples', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🍎'],
                    ['name' => 'Bananas', 'quantity' => '1 bunch', 'bought' => false, 'emoji' => '🍌']
                ],
                'Pantry Items' => [
                    ['name' => 'Rice (Brown)', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🍚'],
                    ['name' => 'Pasta (Spaghetti)', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🍝']
                ],
                'Frozen Foods' => [
                    ['name' => 'Frozen Peas', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '❄️'],
                    ['name' => 'Frozen Pizza', 'quantity' => '1 unit', 'bought' => false, 'emoji' => '🍕']
                ],
                'Beverages' => [
                    ['name' => 'Coffee', 'quantity' => '12 oz', 'bought' => false, 'emoji' => '☕'],
                    ['name' => 'Orange Juice', 'quantity' => '1 gallon', 'bought' => false, 'emoji' => '🍊']
                ]
            ]
        ],
        [
            'name' => 'Week 2',
            'emoji' => '🥗', // Salad emoji for Week 2 (healthy theme)
            'description' => 'Healthy meal prep',
            'items' => [
                'Meat' => [
                    ['name' => 'Turkey Breast', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🦃'],
                    ['name' => 'Bacon', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🥓']
                ],
                'Vegetables' => [
                    ['name' => 'Spinach', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🥬'],
                    ['name' => 'Sweet Potatoes', 'quantity' => '3 lbs', 'bought' => false, 'emoji' => '🍠'],
                    ['name' => 'Bell Peppers', 'quantity' => '2 units', 'bought' => false, 'emoji' => '🫑']
                ],
                'Dairy' => [
                    ['name' => 'Yogurt (Plain)', 'quantity' => '32 oz', 'bought' => false, 'emoji' => '🥛'],
                    ['name' => 'Butter', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🧈']
                ],
                'Fruits' => [
                    ['name' => 'Strawberries', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '🍓'],
                    ['name' => 'Blueberries', 'quantity' => '1 pint', 'bought' => false, 'emoji' => '🫐']
                ],
                'Pantry Items' => [
                    ['name' => 'Olive Oil', 'quantity' => '16 oz', 'bought' => false, 'emoji' => '🫒'],
                    ['name' => 'Black Beans', 'quantity' => '15 oz can', 'bought' => false, 'emoji' => '🥫']
                ],
                'Frozen Foods' => [
                    ['name' => 'Frozen Berries', 'quantity' => '1 lb', 'bought' => false, 'emoji' => '❄️'],
                    ['name' => 'French Fries', 'quantity' => '2 lbs', 'bought' => false, 'emoji' => '🍟']
                ],
                'Beverages' => [
                    ['name' => 'Tea Bags', 'quantity' => '20 count', 'bought' => false, 'emoji' => '🍵'],
                    ['name' => 'Water (Bottled)', 'quantity' => '24 pack', 'bought' => false, 'emoji' => '💧']
                ]
            ]
        ]
    ];

    // Category emojis for table headers
    $categoryEmojis = [
        'Meat' => '🍖',
        'Vegetables' => '🥕',
        'Dairy' => '🥛',
        'Fruits' => '🍎',
        'Pantry Items' => '🥫',
        'Frozen Foods' => '❄️',
        'Beverages' => '🥤'
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_bought'])) {
        $weekIndex = $_POST['week_index'];
        $category = $_POST['category'];
        $itemIndex = $_POST['item_index'];
        $bought = $_POST['bought'] === 'true' ? true : false;
        
        $weeks[$weekIndex]['items'][$category][$itemIndex]['bought'] = $bought;
        echo json_encode(['success' => true]);
        exit;
    }
    ?>

    <div id="weeks-view">
        <h1>Weekly Grocery Plans</h1>
        <div id="weeks-container">
            <?php foreach ($weeks as $index => $week): ?>
                <div class="week-card" onclick="showWeek(<?php echo $index; ?>)">
                    <h2><?php echo $week['emoji'] . ' ' . htmlspecialchars($week['name']); ?></h2>
                    <p><?php echo htmlspecialchars($week['description']); ?></p>
                    <div class="image-placeholder">[Image Placeholder]</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="week-details" class="hidden">
        <button onclick="showWeeks()">Back to Weeks</button>
        <h1 id="week-title"></h1>
        <div id="groceries-table"></div>
        <button id="export-btn">Export List (CSV/PDF)</button>
    </div>

    <script>
        let currentWeekData = <?php echo json_encode($weeks); ?>;
        const categoryEmojis = <?php echo json_encode($categoryEmojis); ?>;
        
        function showWeek(weekIndex) {
            document.getElementById('weeks-view').classList.add('hidden');
            document.getElementById('week-details').classList.remove('hidden');
            
            const week = currentWeekData[weekIndex];
            document.getElementById('week-title').textContent = week.emoji + ' ' + week.name;
            
            let tableHtml = '<table><tr><th>Item</th><th>Quantity</th><th>Bought</th></tr>';
            for (const [category, items] of Object.entries(week.items)) {
                tableHtml += `<tr><td colspan="3">${categoryEmojis[category]} ${category}</td></tr>`;
                items.forEach((item, itemIndex) => {
                    tableHtml += `
                        <tr>
                            <td><span class="item-with-emoji">${item.emoji} ${item.name}</span></td>
                            <td>${item.quantity}</td>
                            <td>
                                <input type="checkbox" 
                                       onchange="updateBought(${weekIndex}, '${category}', ${itemIndex}, this.checked)"
                                       ${item.bought ? 'checked' : ''}>
                            </td>
                        </tr>
                    `;
                });
            }
            tableHtml += '</table>';
            document.getElementById('groceries-table').innerHTML = tableHtml;
        }

        function showWeeks() {
            document.getElementById('week-details').classList.add('hidden');
            document.getElementById('weeks-view').classList.remove('hidden');
        }

        function updateBought(weekIndex, category, itemIndex, bought) {
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `update_bought=true&week_index=${weekIndex}&category=${category}&item_index=${itemIndex}&bought=${bought}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentWeekData[weekIndex].items[category][itemIndex].bought = bought;
                }
            });
        }

        document.getElementById('export-btn').addEventListener('click', () => {
            alert('Export functionality to be implemented later');
        });
    </script>
</body>
</html>