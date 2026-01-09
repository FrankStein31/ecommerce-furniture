<style>
@media (min-width: 992px) {
  .modal-lg {
    width: 80%;
  }
}

.modal-full {
  min-width: 85%;
}
</style>
<div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="modal-detail"
  aria-hidden="true">
  <div id="modal-color" class="modal-dialog modal-lg modal-full modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="font-size:16px;" class="modal-title"><i class="fa fa-align-justify"></i>
          <?= $judul ?></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
              if( ($extensi == "pdf") || ($extensi == "PDF") ){
          ?>
        <center>
          <embed src="<?php echo $file_path; ?>" type="application/pdf" height="600px" style="width:100%">
        </center>
        <?php
              }else{
          ?>
        <center>
          <img src="<?=$file_path?>" style="max-width:100%">
        </center>
        <?php
              }
          ?>
      </div>
      <div class="modal-footer">
        <center>
          <a id="download_dokumen" href="<?php echo site_url('Order/download_file/'.$file_name); ?>"
            class="btn btn-primary"> Download</a>
        </center>
        <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>