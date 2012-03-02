<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('news', 'Index'), array('news/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('news', 'Add Post'), array('news/addpost', 'catid' => $model->id), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>


<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('news', 'Posts'); ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="news-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'><input class="check-all" type="checkbox" /></th>
						   <th style='width: 20%'><?php echo Yii::t('news', 'Title'); ?></th>
						   <th style='width: 20%'><?php echo Yii::t('news', 'Alias'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('news', 'Posted'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('news', 'Author'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('news', 'Status'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('news', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<td><?php echo CHtml::checkbox( 'record[' . $row->id.']' ); ?></td>
							<td><?php echo CHtml::encode($row->title); ?></td>
							<td><?php echo CHtml::encode($row->alias); ?></td>
							<td>
								<?php echo dateTime($row->postdate); ?>
								<?php if( $row->last_updated_date ): ?>
									<br /><small><span class='tooltip' title='<?php echo Yii::t('news', 'Last Modified Date'); ?>'><?php echo Yii::app()->dateFormatter->formatDateTime($row->last_updated_date, 'short', 'short'); ?></span></small>
								<?php endif; ?>	
							</td>
							<td>
								<?php echo $row->author ? CHtml::encode($row->author->username) : Yii::t('adminglobal', 'Unknown'); ?>
								<?php if( $row->last_updated_author ): ?>
									<br /><small><span class='tooltip' title='<?php echo Yii::t('news', 'Last Modified By'); ?>'><?php echo $row->lastauthor ? CHtml::encode($row->lastauthor->username) : Yii::t('adminglobal', 'Unknown'); ?></span></small>
								<?php endif; ?>
							</td>
							<td>
								<?php echo CHtml::link( $row->status ? 'Yes' : 'No', array('news/togglepost', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('news', 'Toggle page status!') ) ); ?>
							</td>
							<td>
								<!-- Icons -->
								 <a href="<?php echo Yii::app()->urlManager->createUrl('news/' . CHtml::encode($row->alias) ); ?>" title="<?php echo Yii::t('news', 'view this post'); ?>" target='_blank' class='icon-button view tooltip'><?php echo Yii::t('admin', 'Preview'); ?></a>
								 <a href="<?php echo $this->createUrl('news/editpost', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Edit this post'); ?>" class='icon-button edit tooltip'><?php echo Yii::t('admin', 'Edit'); ?></a>
								 <a href="<?php echo $this->createUrl('news/deletepost', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Delete this post!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('admin', 'Delete'); ?></a>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='7' style='text-align:center;'><?php echo Yii::t('news', 'No Posts Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($rows) ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<option value="bulkapprove"><?php echo Yii::t('global', 'Approve Selected'); ?></option>
							<option value="bulkunapprove"><?php echo Yii::t('global', 'Hide Selected'); ?></option>
						</select>
						<?php echo CHtml::submitButton( Yii::t('global', 'Apply'), array( 'confirm' => Yii::t('admin', 'Are you sure you would like to perform a bulk operation?'), 'class'=>'button blue small')); ?>
					</div>
					
					<?php endif; ?>
					<?php echo CHtml::endForm(); ?>
					<form>
						<select class="pagesize">
							<option selected="selected" value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
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