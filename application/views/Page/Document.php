<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/Document.css"/>
</head>
<body>
	<div class="container">
		<?php foreach ($data_doc as $val) { ?>

		<div class="row" style="margin-top: 20px;">
			<div class="col">
				<!-- <button class="back" style="float: right">Back</button> -->
			</div>
		</div>
			<div class="row" style="margin-top: 20px;">
				<div class="col-10" style="display: flex;color: white;">
					<h2><?= $val->judul_dokumen ?></h2><i class="fas fa-edit fa-lg" style="margin-left: 10px;margin-top: 10px;"></i>
				</div>
				
				<div class="col-2">
					<button class="input" style="float: right;">Save</button>
				</div>
			</div>

			<input id="id_doc" type="hidden" value="<?php echo $val->id_document?>">

			<div class="row" style="display: block;">
				<div class="document-editor">
					<div id="toolbar-container" ></div>
						<div class="document-editor__editable-container">
							<div id="editor" name="content"> 
								<?= $val->konten_dokumen ?>
							</div>
						</div>
				</div>
			</div>
			<?php } ?>
	</div>

</body>
</html>

<script>
	var values;

    DecoupledEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            const toolbarContainer = document.querySelector( '#toolbar-container' );

            toolbarContainer.appendChild( editor.ui.view.toolbar.element );
            values = editor;
           

        } )
        .catch( error => {
            console.error( error );
        } );


 	$(document).ready(function() {
	  	$('button.input').click(function() {
	  		var val = values.getData();
	  		var id_doc = $('#id_doc').val();
	  		console.log(val);

	  		$.ajax ({
				url : '<?php echo base_url()?>Document_C/Save_Doc',
				method: 'POST',
				data : {val:val,id_doc:id_doc},
								  		
			});
	  	});
	});
</script>
