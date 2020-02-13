<?php $lang = "en" ?>
<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">      <ol class="breadcrumb">        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'event/add'; ?>">Add Blog</a></li>        <li class="breadcrumb-item active"><a>Blog List</a></li>      </ol>    </nav>
    <div class="container-fluid">
      <div class="text-right mb-2"><a href="<?= base_url() ?>event/add" class="btn btn-primary"><i class="la la-plus"></i> Add Blog</a></div>
      <?php
		if ($this->session->flashdata('succ_msg')) {
	  ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
        <?= $this->session->flashdata('succ_msg') ?>
      </div>
      <?php
		}
		if ($this->session->flashdata('error_msg')) {
		?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php
		}
		?>
      <table class="table table-hover table-bordered adminmenu_list">
        <thead>
          <tr>
            <th>Id</th>
            <th>Blog title</th>
            <th>Posted Date</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
			$attr = array(
				'onclick' => "javascript: return confirm('Do you want to delete?');",
				'class' => 'i-cancel-circle-2 red',
				'title' => 'Delete'
			);
			$atr3 = array(
				'onclick' => "javascript: return confirm('Do you want to active this?');",
				'class' => 'i-checkmark-3 red',
				'title' => 'Inactive'
			);
			$atr4 = array(
				'onclick' => "javascript: return confirm('Do you want to inactive this?');",
				'class' => 'i-checkmark-3 green',
				'title' => 'Active'
			);

			//	$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
			//$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
		if(count($list)>0){
			foreach ($list as $key => $event) {				
				?>
          <tr>
            <td><?php echo $event['event_id']; ?></td>
            <td>			<?php			$title = $this->db->select('title')->from('event_detail')->where(array('event_id'=>$event['event_id'],'lang'=>$lang))->get()->row_array();			if(!empty($title['title'])){				echo $title['title'];			} else {				echo '--';			}			?>			</td>
            <td><?php echo date('d M, Y',strtotime($event['created'])); ?></td>
            <td align="center"><?php
				if ($event['status'] == 'Y') {
					echo anchor(base_url() . 'event/change_status/' . $event['event_id'] . '/inact/', '&nbsp;', $atr4);
				} else {

					echo anchor(base_url() . 'event/change_status/' . $event['event_id'] . '/act/', '&nbsp;', $atr3);
				}
				?></td>
            <td align="center"><?php
				$atr2 = array('class' => 'i-highlight', 'title' => 'Edit Event');
				echo anchor(base_url() . 'event/edit/' . $event['event_id'], '&nbsp;', $atr2);
				echo anchor(base_url() . 'event/delete_event/' . $event['event_id'], '&nbsp;', $attr);
				?></td>
          </tr>
		<?php } } ?>
        </tbody>
      </table>
      <?php echo $links; ?>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
