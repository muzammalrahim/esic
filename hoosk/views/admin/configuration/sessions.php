   <?php echo $header; ?>
   <div class="">

   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sessions
            <small>LIST</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Sessions</a></li>
            <li class="active">list</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Esic Sessions</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="sessions" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>IP Address</th>
                                <th>Descriptions</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($get_sessions){
                                $no=0;
                                foreach ($get_sessions as $data){$no++;?>
                                <tr>
                                <td><?= $no ?></td>
                                <td><?= $data['ip_address'] ?></td>
                                <td><?php
                                    $res = str_replace(';pageHasSlider','', $data['data']);
                                    $res = str_replace('__ci_last_regenerate','',$res);

                                    $array = explode('|',$res);
                                        foreach ($array as $des){
                                           echo $des.'<br>';
                                        }
                                    ?></td>

                                <td><?= $data['created'] ?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>IP Address</th>
                                <th>Descriptions</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div> <!-- /.box-body -->
                    <div class="box-footer">
                        Total <?= $total; ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
   <script>
       $(document).ready( function () {
           $('#sessions').DataTable();
       } );
      </script>
   <?php echo $footer; ?>