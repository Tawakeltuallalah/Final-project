<?php
session_start();
require 'dbconfig.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
//     header("Location: login.php");
//     exit();
// }

// Get filter values from request
$school_name = $_GET['school_name'] ?? '';
$location = $_GET['location'] ?? '';
$school_type = $_GET['school_type'] ?? '';

// Build filter conditions
$conditions = [];
if (!empty($school_name)) {
    $conditions[] = "s.School_name = '$school_name'";
}
if (!empty($location)) {
    $conditions[] = "s.Location = '$location'";
}
if (!empty($school_type)) {
    $conditions[] = "s.School_type = '$school_type'";
}
$where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Fetch filter options
$school_names = $conn->query("SELECT DISTINCT School_name FROM school")->fetch_all(MYSQLI_ASSOC);
$locations = $conn->query("SELECT DISTINCT Location FROM school")->fetch_all(MYSQLI_ASSOC);
$school_types = $conn->query("SELECT COLUMN_TYPE FROM information_schema.COLUMNS 
                            WHERE TABLE_NAME = 'school' AND COLUMN_NAME = 'School_type'")
                            ->fetch_array()[0];
preg_match("/enum\(\'(.*)\'\)/", $school_types, $matches);
$school_type_options = explode("','", $matches[1]);

// Fetch statistics with filters
$total_schools = $conn->query("SELECT COUNT(*) as total FROM school s $where")->fetch_assoc()['total'];
$total_teachers = $conn->query("SELECT COUNT(*) as total FROM teacher t JOIN school s ON t.School_id = s.School_id $where")->fetch_assoc()['total'];
$total_students = $conn->query("SELECT COUNT(*) as total FROM student st JOIN school s ON st.School_id = s.School_id $where")->fetch_assoc()['total'];

// Gender statistics with filters
$teacher_gender = $conn->query("SELECT 
    SUM(gender = 'Male') as male,
    SUM(gender = 'Female') as female 
    FROM teacher t 
    JOIN school s ON t.School_id = s.School_id 
    $where")->fetch_assoc();

$student_gender = $conn->query("SELECT 
    SUM(gender = 'Male') as male,
    SUM(gender = 'Female') as female 
    FROM student st 
    JOIN school s ON st.School_id = s.School_id 
    $where")->fetch_assoc();

// Calculate percentages
$teacher_male_percent = $total_teachers > 0 ? ($teacher_gender['male'] / $total_teachers) * 100 : 0;
$teacher_female_percent = $total_teachers > 0 ? ($teacher_gender['female'] / $total_teachers) * 100 : 0;
$student_male_percent = $total_students > 0 ? ($student_gender['male'] / $total_students) * 100 : 0;
$student_female_percent = $total_students > 0 ? ($student_gender['female'] / $total_students) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Management Dashboard</title>
    <style>
        :root {
            --primary-blue: #2196F3;
            --primary-green: #4CAF50;
            --primary-pink: #E91E63;
            --primary-purple: #9C27B0;
            --background: #f5f5f5;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background: var(--background);
        }

        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-item {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-width: 120px;
        }

        .search-btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .reset-btn {
            background: #ff5722;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .stat-header {
            color: #666;
            margin: 0 0 15px 0;
            font-size: 1.1rem;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--primary-blue);
        }

        .gender-breakdown {
            color: #666;
            line-height: 1.6;
        }

        .percentage-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .percentage-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-top: 20px;
        }

        .percentage-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .percentage-label {
            color: #666;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .progress-bar {
            height: 30px;
            background: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            display: flex;
            align-items: center;
            padding-left: 15px;
            font-size: 14px;
            font-weight: bold;
            transition: width 0.5s ease;
        }

        .percentage-number {
            margin-top: 10px;
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary-blue);
            text-align: right;
        }

        .blue { background: var(--primary-blue); }
        .green { background: var(--primary-green); }
        .pink { background: var(--primary-pink); }
        .purple { background: var(--primary-purple); }

        .percentage-text {
            position: relative;
            z-index: 2;
            color: white;
        }
    </style>
</head>
<body>
    <form method="GET">
        <div class="filter-section">
            <select class="filter-item" name="school_name">
                <option value="">All Schools</option>
                <?php foreach ($school_names as $school): ?>
                <option value="<?= htmlspecialchars($school['School_name']) ?>" 
                    <?= $school['School_name'] == $school_name ? 'selected' : '' ?>>
                    <?= htmlspecialchars($school['School_name']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select class="filter-item" name="location">
                <option value="">All Locations</option>
                <?php foreach ($locations as $loc): ?>
                <option value="<?= htmlspecialchars($loc['Location']) ?>" 
                    <?= $loc['Location'] == $location ? 'selected' : '' ?>>
                    <?= htmlspecialchars($loc['Location']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select class="filter-item" name="school_type">
                <option value="">School Types</option>
                <?php foreach ($school_type_options as $type): ?>
                <option value="<?= $type ?>" <?= $type == $school_type ? 'selected' : '' ?>>
                    <?= ucfirst($type) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <select class="filter-item" name="school_category">
                <option value="">School category</option>
                <?php foreach ($school_category_options as $type): ?>
                <option value="<?= $type ?>" <?= $type == $school_category ? 'selected' : '' ?>>
                    <?= ucfirst($type) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="search-btn">Q Search</button>
            <button type="button" class="reset-btn" onclick="window.location.href=window.location.pathname">Reset</button>
        </div>
    </form>

    <div class="stats-container">
        <div class="stat-card">
            <h3 class="stat-header">Teachers</h3>
            <div class="stat-number"><?= number_format($total_teachers) ?></div>
            <div class="gender-breakdown">
                Male: <?= number_format($teacher_gender['male']) ?><br>
                Female: <?= number_format($teacher_gender['female']) ?>
            </div>
        </div>

        <div class="stat-card">
            <h3 class="stat-header">Students</h3>
            <div class="stat-number"><?= number_format($total_students) ?></div>
            <div class="gender-breakdown">
                Male: <?= number_format($student_gender['male']) ?><br>
                Female: <?= number_format($student_gender['female']) ?>
            </div>
        </div>

        <div class="stat-card">
            <h3 class="stat-header">Schools</h3>
            <div class="stat-number"><?= number_format($total_schools) ?></div>
        </div>
    </div>

    <div class="percentage-section">
        <h2>Percentage of Teachers Statistics</h2>
        <div class="percentage-grid">
            <div class="percentage-item">
                <div class="percentage-label">Male</div>
                <div class="progress-bar">
                    <div class="progress-fill blue" style="width: <?= round($teacher_male_percent, 2) ?>%">
                        <span class="percentage-text"><?= round($teacher_male_percent, 2) ?>%</span>
                    </div>
                </div>
                <div class="percentage-number"><?= number_format($teacher_gender['male']) ?></div>
            </div>
            <div class="percentage-item">
                <div class="percentage-label">Female</div>
                <div class="progress-bar">
                    <div class="progress-fill pink" style="width: <?= round($teacher_female_percent, 2) ?>%">
                        <span class="percentage-text"><?= round($teacher_female_percent, 2) ?>%</span>
                    </div>
                </div>
                <div class="percentage-number"><?= number_format($teacher_gender['female']) ?></div>
            </div>
        </div>

        <h2 style="margin-top: 30px;">Percentage of Students Statistics</h2>
        <div class="percentage-grid">
            <div class="percentage-item">
                <div class="percentage-label">Male</div>
                <div class="progress-bar">
                    <div class="progress-fill green" style="width: <?= round($student_male_percent, 2) ?>%">
                        <span class="percentage-text"><?= round($student_male_percent, 2) ?>%</span>
                    </div>
                </div>
                <div class="percentage-number"><?= number_format($student_gender['male']) ?></div>
            </div>
            <div class="percentage-item">
                <div class="percentage-label">Female</div>
                <div class="progress-bar">
                    <div class="progress-fill purple" style="width: <?= round($student_female_percent, 2) ?>%">
                        <span class="percentage-text"><?= round($student_female_percent, 2) ?>%</span>
                    </div>
                </div>
                <div class="percentage-number"><?= number_format($student_gender['female']) ?></div>
            </div>
        </div>
    </div>

</body>
</html>