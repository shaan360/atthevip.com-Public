<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('news', 'Comments'), array('news/comments'), array( 'class' => 'button red medium' )); ?>
	<?php echo CHtml::link(Yii::t('news', 'Add Category'), array('news/addcategory'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('news', 'Add Post'), array('news/addpost'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('news', 'Categories'); ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="settings-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 5%;'><?php echo Yii::t('news', 'Position'); ?></th>
						   	<th style='width: 20%;'><?php echo Yii::t('news', 'Title'); ?></th>
						  	<th style='width: 10%;'><?php echo Yii::t('news', 'Alias'); ?></th>
							<th style='width: 25%;'><?php echo Yii::t('news', 'Description'); ?></th>
							<th style='width: 10%;'><?php echo Yii::t('news', 'Read Only'); ?></th>
							<th style='width: 5%;'><?php echo Yii::t('news', 'Posts'); ?></th>
						   	<th style='width: 15%;'><?php echo Yii::t('news', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<td><?php echo CHtml::textField( 'pos[' . $row->id.']', $row->position, array('size'=>1) ); ?></td>
							<td><a href="<?php echo $this->createUrl('news/viewcategory', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('news', 'View Posts'); ?>" class='tooltip'><?php echo CHtml::encode($row->title); ?></a></td>
							<td><?php echo CHtml::encode($row->alias); ?></td>
							<td><?php echo CHtml::encode($row->description); ?></td>
							<td>
								<?php echo CHtml::link( $row->readonly ? 'Yes' : 'No', array('news/catreadonly', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('custompages', 'Toggle page status!') ) ); ?>
							</td>
							<td><?php echo Yii::app()->format->number( $row->count ); ?></td>
							<td>
								<!-- Icons -->
								<a href="<?php echo Yii::app()->urlManager->createUrl('news/category/' . $row->alias); ?>" title="<?php echo Yii::t('news', 'View category'); ?>" class='icon-button view tooltip'><?php echo Yii::t('admin', 'View'); ?></a>
								<a href="<?php echo $this->createUrl('news/addpost', array( 'catid' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Add post to this category'); ?>" class='icon-button add tooltip'><?php echo Yii::t('admin', 'Add'); ?></a>
								<a href="<?php echo $this->createUrl('news/addcategory', array( 'parentid' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Add sub category to this category'); ?>" class='icon-button add tooltip'><?php echo Yii::t('admin', 'Add'); ?></a>
								<a href="<?php echo $this->createUrl('news/editcategory', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Edit this category'); ?>" class='icon-button edit tooltip'><?php echo Yii::t('admin', 'Edit'); ?></a>
								<a href="<?php echo $this->createUrl('news/deletecategory', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Delete this category!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('admin', 'Delete'); ?></a>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='7' style='text-align:center;'><?php echo Yii::t('settings', 'No Categories Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($rows) ): ?>
					<div class="table-options">
						<?php echo CHtml::submitButton( Yii::t('global', 'Reorder'), array('name' => 'submit', 'class'=>'button blue small')); ?>
					</div>
					
					<?php endif; ?>
					<?php echo CHtml::endForm(); ?>
					<form>
						<select class="pagesize">
							<option selected="selected" value="100">100</option>
							<option value="200">200</option>
							<option value="300">300</option>
							<option value="400">400</option>
						</select>
						<a class="button small green first"><img src="<?php echo themeUrl(); ?>/images/table_pager_first.png" alt="First" /></a>
						<a class="button small green prev"><img src="<?php echo themeUrl(); ?>/images/table_pager_previous.png" alt="Previous" /></a>
						<input type="text" class="pagedisplay" disabled="disabled" />
						<a class="button small green next"><img src="<?php echo themeUrl(); ?>/images/table_pager_next.png" alt="Next" /></a>
						<a class="button small green last"><img src="<?php echo themeUrl(); ?>/images/table_pager_last.png" alt="Last" /></a>
					</form>
				</div>
				
			</div>
		</div>
	</div>
	
</div>

<?php JSFile( themeUrl() . '/js/modules/news.js' ); ?>
