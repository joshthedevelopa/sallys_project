<div id="main-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fa fa-dashboard"></i>
                <h2>Recovery</h2>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fa fa-dashboard"></i>
                <h3>List of Backups</h3>
            </div>
            <div class="card-action">
                <ul>
                    <li class="navigation-btn" target="backup_form"> 
                        <i class="fa fa-sm fa-cloud-upload"></i>
                        <h5>Create A Backup</h5>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table id="table-data" class="selective-table" data="backups">
                <thead>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>Backup Name</td>
                        <td>By</td>
                        <td>Backup Size</td>
                        <td>Backup Date</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="sub-content">
    <div class="tile-body" style="padding: 0; padding-bottom: 4px;">
        <div class="close-btn" target="#sub-content">
            <i class="fa fa-close"></i>
        </div>
    </div>

    <div class="tile">
        <i class='fa fa-user'></i>
        <div>
            <div class="tile-body">
                <div class="intro">Name</div>
                <div class="title  data-holder" data="name">None</div>
            </div>
            <div class="tile-body">
                <div class="intro">Description</div>
                <div class="title  data-holder" data="description">None</div>
            </div>

        </div>
    </div>

    <div class="tile">
        <i class='fa fa-clipboard'></i>
        <div>
            <div class="tile-body">
                <div class="intro">Last Backup Size</div>
                <div class="title  data-holder" data="backup_size">None</div>
            </div>
            <div class="tile-body">
                <div class="intro">Last Backup Date</div>
                <div class="title  data-holder" data="date_created">None</div>
            </div>
        </div>
    </div>

    <div class='tile'>
        <div class="row">
            <div class="btn btn-primary data-holder-action" action="delete_backup" data="None">Delete</div>
            <div class="btn btn-primary data-holder-action" action="restore_backup" data="None">Restore</div>
        </div>
    </div>

    <div class="tile">
        <i class='fa fa-database'></i>
        <div>
        <div class="tile-body">
                <div class="intro">Customers Name</div>
                <div class="title  data-holder" data="customer_name">None</div>
            </div>
            <div class="tile-body">
                <div class="intro">Customers Contact</div>
                <div class="title  data-holder" data="customer_contact">None</div>
            </div>
            <div class="tile-body">
                <div class="intro">Backup Quota</div>
                <div class="title  data-holder" data="customer_backup_quota">None</div>
            </div>
            <div class="tile-body">
                <div class="intro">Total Backup Size</div>
                <div class="title  data-holder" data="customer_backup_size">None</div>
            </div>
        </div>
    </div>

</div>