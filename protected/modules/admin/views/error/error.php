<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('adminglobal', 'Error'); ?></h2>
			<div class="content">
				<p><?php echo $error['message']; ?></p>
				<?php if( YII_DEBUG ): ?>
				<table>
					<tbody>
						<tr>
							<td style='width: 5%;'><?php echo Yii::t('admindebug', 'File:'); ?></td>
							<td style='width: 95%;'><?php echo $error['file'] . '(<b>'. $error['line'] .'</b>)' ; ?></td>
						</tr>
						<tr>
							<td style='width: 5%;'><?php echo Yii::t('admindebug', 'Type:'); ?></td>
							<td style='width: 95%;'><?php echo $error['type'] . ' ' . $error['code']; ?></td>
						</tr>
						<?php if( $error['trace'] ): ?>
							<?php foreach( explode("\n", $error['trace']) as $trace ): ?>
								<tr>
									<td colspan='2'><?php echo $trace; ?></td>
								</tr>
							<?php endforeach; ?>	
						<?php endif; ?>
						<?php if( isset($error['source']) && count($error['source']) ): ?>
							<tr>
								<td colspan='2'>
							<?php foreach( $error['source'] as $number => $line ): ?>
									<?php echo $number . $line; ?><br />
							<?php endforeach; ?>
								</td>
							</tr>	
						<?php endif; ?>
						
					</tbody>
				</table>
				
			<?php endif; ?>
			</div>
		</div>
	</div>
	
</div>