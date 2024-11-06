<?= $this->extend('layouts/investor_nav.php') ?>  

<?= $this->section('content') ?>

<?php
// Load the CodeIgniter database service
$db = \Config\Database::connect();

// Check if the category is passed in the URL
if (isset($_GET['category'])) {
    $userId = session()->get('user_id');
    $selectedCategory = $_GET['category'];

    // Update the user's preferred category in the database
    $builder = $db->table('users');
    $builder->where('id', $userId);
    $builder->update(['preferred_category' => $selectedCategory]);
}
?>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/idea.css');?>">
</head>
<body>

    <div class="container">
        <main class="main-content">
            <header class="main-header">
                <h1>Hello, <span class="username"><?= session()->get('username'); ?></span></h1>
                <p>Today is <?= date('l, d F Y'); ?></p>
                <a href="" class="add-project-btn">Progress Report?</a>
            </header>

            <!-- PHP Code for Fetching Pitches -->
            <?php
            $userId = session()->get('user_id');

            // Get the user's preferred category
            $builder = $db->table('users');
            $builder->select('preferred_category');
            $builder->where('id', $userId);
            $query = $builder->get();
            $categoryRow = $query->getRowArray();
            $preferredCategory = $categoryRow['preferred_category'];

            // Fetch pitches in the preferred category
            $pitchBuilder = $db->table('pitch');
            $pitchBuilder->where('category', $preferredCategory);
            $pitchesResult = $pitchBuilder->get()->getResultArray();
            ?>

            <section class="projects-overview">
                <a href="?category=E-commerce" class="project-link">
                    <div class="project-card purple">
                        <h3>E-commerce</h3>
                        <p>the trading of goods and services online</p>
                        <div class="project-progress"></div>
                    </div>
                </a>

                <a href="?category=Technology" class="project-link">
                    <div class="project-card blue">
                        <h3>Technology</h3>
                        <p>A hub for Business Process Outsourcing & Information Technology services, catering to global clients.</p>
                        <div class="project-progress"></div>
                    </div>
                </a>

                <a href="?category=Food & Beverage" class="project-link">
                    <div class="project-card orange">
                        <h3>Food & Beverage</h3>
                        <p>Health and wellness, convenience foods, and dining experiences</p>
                        <div class="project-progress"></div>
                    </div>
                </a>
            </section>

            <!-- Display Recommended Pitches -->
            <section class="recommended-pitches">
                <h2>Recommended Investment Pitches</h2>
                <?php if (!empty($pitchesResult)) : ?>
                    <?php foreach ($pitchesResult as $pitch) : ?>
                        <div class="pitch">
                            <h3><?= htmlspecialchars($pitch['project_name']); ?></h3>
                            <p><?= htmlspecialchars($pitch['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No investment pitches available in your preferred category.</p>
                <?php endif; ?>
            </section>

            <!-- New Daily Sales Report Section -->
            <section class="daily-sales-report">
                <h2>Startups Progress Reports</h2>
                <table class="sales-report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Project Name</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Startup</th>
                            <th>Status</th>
                            <th>Description</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#015</td>
                            <td>Shopee</td>
                            <td>Ecommerce</td>
                            <td>$25006</td>
                            <td>Startup</td>
                            <td><span class="status approved">Approved</span></td>
                            <td>Description</td>
                        </tr>
                        <tr>
                            <td>#015</td>
                            <td>Shopee</td>
                            <td>Ecommerce</td>
                            <td>$25006</td>
                            <td>Startup</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>Description</td>
                        </tr>
                        <tr>
                            <td>#015</td>
                            <td>Shopee</td>
                            <td>Ecommerce</td>
                            <td>$25006</td>
                            <td>Startup</td>
                            <td><span class="status rejected">Rejected</span></td>
                            <td>Description</td>
                        </tr>
                        <tr>
                            <td>#015</td>
                            <td>Shopee</td>
                            <td>Ecommerce</td>
                            <td>$25006</td>
                            <td>Startup</td>
                            <td><span class="status approved">Approved</span></td>
                            <td>DescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescriptionDescription</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <h2>Requests</h2>
            <?php if (!empty($requests)) : ?>
                <?php foreach ($requests as $request) : ?>
                    <div class="notification-item">
                        <a href="<?= base_url('startup_profile/' . $request['startup_id']); ?>" 
                           class="startup-name-link" style="text-decoration: none; color: inherit;">
                            <p><?= esc($request['startup_name']); ?> sent you a request!</p>
                        </a>
                        <span class="notification-time"><?= $request['created_at']; ?></span>
                        <div class="notification-actions">
                            <a href="<?= base_url('invest_dashboard/handleRequest/' . $request['id'] . '/accept'); ?>" class="accept-btn">Accept</a>
                            <a href="<?= base_url('invest_dashboard/handleRequest/' . $request['id'] . '/decline'); ?>" class="decline-btn">Decline</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No requests available.</p>
            <?php endif; ?>
        </main>
    </div>

</body>

<?= $this->endSection() ?>
