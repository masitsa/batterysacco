<?php
        // print_r($query);
        $result = '';
        
        //if users exist display them
        if ($query->num_rows() > 0)
        {
            $count = $page;
            
            $result .= 
            '
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><a href="'.site_url().'microfinance/group/group_name/'.$order_method.'/'.$page.'">Amount</a></th>
                        <th><a href="'.site_url().'microfinance/group/group_contact_fname/'.$order_method.'/'.$page.'">Slip Number</a></th>
                        <th><a href="'.site_url().'microfinance/group/group_phone/'.$order_method.'/'.$page.'">Date Paid</a></th>
                        <th><a href="'.site_url().'microfinance/group/group_status/'.$order_method.'/'.$page.'">Month Paid For</a></th>
                        <th colspan="5">Actions</th>
                    </tr>
                </thead>
                  <tbody>
                  
            ';
            
            //get all administrators
            $administrators = $this->users_model->get_active_users();
            if ($administrators->num_rows() > 0)
            {
                $admins = $administrators->result();
            }
            
            else
            {
                $admins = NULL;
            }
            
            foreach ($query->result() as $row)
            {
                $group_id = $row->id;
                $amount = $row->amount;
                $slipnumber = $row->slip_number;
                $date_paid = $row->date_paid;
                $month_paid = $row->month_paid_for;
                $group_name = $title;

                //create deactivated status display
               
                $count++;
                $result .= 
                '
                    <tr>
                        <td>'.$count.'</td>
                        <td>'.$amount.'</td>
                        <td>'.$slipnumber.'</td>
                        <td>'.$date_paid.'</td>
                        <td>'.$month_paid.'</td>
                        <td><a href="'.site_url().'microfinance/edit-individual-payment/'.$group_id.'" class="btn btn-sm btn-success" title="Edit '.$group_name.'"><i class="fa fa-pencil"></i></a></td>
                        <td><a href="'.site_url().'microfinance/delete-individual-payment/'.$group_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$group_name.'?\');" title="Delete '.$group_name.'"><i class="fa fa-trash"></i></a></td>
                    </tr> 
                ';
            }
            
            $result .= 
            '
                          </tbody>
                        </table>
            ';
        }
        
        else
        {
            $result .= "There are no groups";
        }
?>

                        <section class="panel">
                            <header class="panel-heading">                      
                                <h2 class="panel-title"><?php echo $title;?></h2>
                            </header>
                            <div class="panel-body">
                                <?php
                                $success = $this->session->userdata('success_message');
        
                                if(!empty($success))
                                {
                                    echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
                                    $this->session->unset_userdata('success_message');
                                }
                                
                                $error = $this->session->userdata('error_message');
                                
                                if(!empty($error))
                                {
                                    echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
                                    $this->session->unset_userdata('error_message');
                                }
                                ?>
                                <div class="row " style="margin-bottom:20px;">
                                    <div class="col-lg-2 col-lg-offset-8">
                                        <a href="<?php echo site_url();?>microfinance/export-individual-payments" class="btn btn-sm btn-success pull-right">Export</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="<?php echo site_url();?>microfinance/add-individual-payment" class="btn btn-sm btn-info pull-right">Add Payment</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    
                                    <?php echo $result;?>
                            
                                </div>
                            </div>
                            <div class="panel-footer">
                                <?php if(isset($links)){echo $links;}?>
                            </div>
                        </section>