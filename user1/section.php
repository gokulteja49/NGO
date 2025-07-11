<?php 
include 'common/connect.php';

// Fetch top 3 campaigns with the highest amount raised
$result = $obj->query("SELECT * FROM campaigns ORDER BY raised DESC LIMIT 3");
?>

<section class="top-campaigns-section">
    <div class="container">
        <h2 class="section-title">Top Campaigns</h2>
        <div class="campaigns-container">
            <?php while ($row = $result->fetch_object()) { ?>
                <div class="campaign-card">
                    <img src="../admin/uploads/<?php echo htmlspecialchars($row->image); ?>" alt="Campaign Image" class="campaign-image">
                    <div class="campaign-content">
                        <h3><?php echo htmlspecialchars($row->title); ?></h3>
                        <p><strong>Goal:</strong> Rs<?php echo number_format($row->goal, 2); ?></p>
                        <p><strong>Raised:</strong> Rs<?php echo number_format($row->raised, 2); ?></p>

                        <div class="progress-container">
                            <div class="progress-bar" style="width: <?php echo ($row->raised / $row->goal) * 100; ?>%"></div>
                        </div>

                        <a href="campaigns.php?id=<?php echo $row->campaign_id; ?>" class="donate-btn">View Campaign</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<style>
/* Top Campaigns Section */
.top-campaigns-section {
    padding: 50px 0;
    background: #f5f5f5;
    text-align: center;
}

.section-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 30px;
}

.campaigns-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.campaign-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    width: 300px;
    text-align: left;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.campaign-card:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.campaign-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.campaign-content {
    padding: 15px;
}

.progress-container {
    width: 100%;
    height: 10px;
    background: #ddd;
    border-radius: 5px;
    overflow: hidden;
    margin-top: 10px;
}

.progress-bar {
    height: 100%;
    background: #28a745;
    width: 0;
    transition: width 0.4s ease-in-out;
}

.donate-btn {
    display: inline-block;
    background: #ff5722;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    margin-top: 10px;
    transition: background 0.3s;
}

.donate-btn:hover {
    background: #e64a19;
}

/* Responsive */
@media (max-width: 768px) {
    .campaigns-container {
        flex-direction: column;
        align-items: center;
    }
}
</style>
