<?php $cacheTime = 60 * 60; ?>
<div class="container_4">

	<div class="grid_2">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('admin', 'Statistics'); ?></h2>
			<div class="content">
				<table class="tablesorter styled">
					<thead>
					<tr>
						<th style='width: 40%'>&nbsp;</th>
						<th style='width: 2%'><?php echo Yii::t('admin', 'T'); ?></th>
						<th style='width: 2%'><?php echo Yii::t('admin', 'P'); ?></th>
						<th style='width: 2%'><?php echo Yii::t('admin', 'H'); ?></th>
						<th style='width: 40%'>&nbsp;</th>
						<th style='width: 2%'><?php echo Yii::t('admin', 'T'); ?></th>
						<th style='width: 2%'><?php echo Yii::t('admin', 'P'); ?></th>
						<th style='width: 2%'><?php echo Yii::t('admin', 'H'); ?></th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo Yii::t('admin', 'Events'); ?></td>
							<td><?php echo numberFormat(Event::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(Event::model()->cache($cacheTime)->count('is_public=1')); ?></td>
							<td><?php echo numberFormat(Event::model()->cache($cacheTime)->count('is_public=0')); ?></td>
							
							<td><?php echo Yii::t('admin', 'Clubs'); ?></td>
							<td><?php echo numberFormat(Club::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(Club::model()->cache($cacheTime)->count('is_public=1')); ?></td>
							<td><?php echo numberFormat(Club::model()->cache($cacheTime)->count('is_public=0')); ?></td>
						</tr>
						<tr>
							<td><?php echo Yii::t('admin', 'Galleries'); ?></td>
							<td><?php echo numberFormat(Gallery::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(Gallery::model()->cache($cacheTime)->count('is_public=1')); ?></td>
							<td><?php echo numberFormat(Gallery::model()->cache($cacheTime)->count('is_public=0')); ?></td>
							
							<td><?php echo Yii::t('admin', 'Gallery Images'); ?></td>
							<td><?php echo numberFormat(GalleryImage::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(GalleryImage::model()->cache($cacheTime)->count('is_public=1')); ?></td>
							<td><?php echo numberFormat(GalleryImage::model()->cache($cacheTime)->count('is_public=0')); ?></td>
						</tr>
						<tr>
							<td><?php echo Yii::t('admin', 'News'); ?></td>
							<td><?php echo numberFormat(News::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(News::model()->cache($cacheTime)->count('status=1')); ?></td>
							<td><?php echo numberFormat(News::model()->cache($cacheTime)->count('status=0')); ?></td>
							
							<td><?php echo Yii::t('admin', 'Custom Pages'); ?></td>
							<td><?php echo numberFormat(CustomPages::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(CustomPages::model()->cache($cacheTime)->count('status=1')); ?></td>
							<td><?php echo numberFormat(CustomPages::model()->cache($cacheTime)->count('status=0')); ?></td>
						</tr>
						<tr>
							<td><?php echo Yii::t('admin', 'Media Containers'); ?></td>
							<td><?php echo numberFormat(MediaContainer::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(MediaContainer::model()->cache($cacheTime)->count('is_public=1')); ?></td>
							<td><?php echo numberFormat(MediaContainer::model()->cache($cacheTime)->count('is_public=0')); ?></td>
							
							<td><?php echo Yii::t('admin', 'Media Objects'); ?></td>
							<td><?php echo numberFormat(MediaObject::model()->cache($cacheTime)->count()); ?></td>
							<td><?php echo numberFormat(MediaObject::model()->cache($cacheTime)->count('is_active=1')); ?></td>
							<td><?php echo numberFormat(MediaObject::model()->cache($cacheTime)->count('is_active=0')); ?></td>
						</tr>
						<tr>
							<td><?php echo Yii::t('admin', 'Users'); ?></td>
							<td><?php echo numberFormat(Users::model()->cache($cacheTime)->count()); ?></td>
							<td>--</td>
							<td>--</td>
							
							<td><?php echo Yii::t('admin', 'Users Online'); ?></td>
							<td><?php echo numberFormat(Sessions::model()->cache($cacheTime)->count()); ?></td>
							<td>--</td>
							<td>--</td>
						</tr>
					</tbody>					
				</table>
			</div>
		</div>
	</div>
	
	<?php $admins = AdminUsers::model()->findAll(); ?>
	
	<div class="grid_2">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('admin', 'Logged In Users'); ?></h2>
			<div class="content">
				<table class="tablesorter styled">
					<thead>
					<tr>
						<th style='width: 20%'><?php echo Yii::t('admin', 'Username'); ?></th>
						<th style='width: 20%'><?php echo Yii::t('admin', 'Logged In'); ?></th>
						<th style='width: 20%'><?php echo Yii::t('admin', 'Last Click'); ?></th>
						<th style='width: 20%'><?php echo Yii::t('admin', 'Location'); ?></th>
					</tr>
					</thead>
					<?php if(count($admins)): ?>
						<?php foreach($admins as $admin): ?>
							<tr>
								<td><?php echo $admin->user->username; ?></td>
								<td><?php echo dateTime($admin->loggedin_time); ?></td>
								<td><?php echo dateTime($admin->lastclick_time); ?></td>
								<td><?php echo ucwords($admin->location); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="4" style="text-align: center;"><?php echo Yii::t('admin', 'None.'); ?></td>
						</tr>
					<?php endif; ?>
					
				</table>
			</div>
		</div>
	</div>
	
</div>

<?php JSFile( themeUrl() . '/js/modules/index.js' ); ?>