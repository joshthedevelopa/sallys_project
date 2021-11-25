<div id="main-content">
    <div class="row row-4">
        <div class="card">
            <div class="card-header">Number of users</div>
            <div class="card-body center dashboard-card-text" id="user_count"></div>
        </div>
        <div class="card">
            <div class="card-header">Number of backups</div>
            <div class="card-body center dashboard-card-text" id="backup_count"></div>
        </div>
        <div class="card">
            <div class="card-header">Total Backup Quota</div>
            <div class="card-body center dashboard-card-text" id="backup_quota"></div>
        </div>
        <div class="card">
            <div class="card-header">Total Backup Size</div>
            <div class="card-body center dashboard-card-text" id="backup_size"></div>
        </div>
    </div>
    <div class="" style="display: flex">
        <div class="card" style="flex: 2">
            <div class="card-body">
                <canvas id="customer_backup_chart-line" height="150"></canvas>
            </div>
        </div>

        <div class="card" style="flex: 1">
            <div class="card-body">
            <canvas id="customer_backup_chart-doughnut" height="150"></canvas>
            </div>
        </div>

    </div>
</div>