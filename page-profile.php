<? get_header(); ?>
<div class="entry-content">
	<?php
	$user = wp_get_current_user();
	$user_name = $user->display_name;
	$user_number = $user->number;
	$now_year = date('Y');
	$now_month = date('m');
	$now_month_data = str_pad($now_month, 2, 0, STR_PAD_LEFT);
	$before_year = $now_year - 1;
	$before_month = $now_month - 1;
	$before_month_data = str_pad($before_month, 2, 0, STR_PAD_LEFT);
	$before_month_lastday = (new DateTimeImmutable)->modify('last day of last month')->format('d');
	var_dump($user_number);
	?>
	<div class="cliant_name">
		<div class="name"><?php echo esc_html($user_name . '　御中') ?></div>
		<div class="logout"><a href="<?php echo wp_logout_url(home_url()); ?>">ログアウト</a></div>
	</div>
	<p>＜最新の請求書＞</p>
	<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$terms = get_terms('tenant-category', '');
	$the_query = new WP_Query(
		array(
			'post_status' => 'any',
			'post_type' => 'attachment',
			'post_mime_type' => 'application/pdf',
			'posts_per_page' => -1,
		)
	);

	if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();

			$pdf_url = wp_get_attachment_url($the_query->post->ID); //メディアのURLを返す
	?>
			<?php if (strpos($pdf_url, $user_number . '-')) : ?>
				<?php if ($now_year == 1) : //1月の時 
				?>
					<?php if (date('d') > 0 && date('d') < 20) : //1日～19日の時 
					?>
						<!-------------------------20日締めの請求書も、月末締めの請求書も、12月の請求書を表示----------------------------------->
						<?php if (strpos($pdf_url, '_' . $before_year . '1220') !== false || strpos($pdf_url, '_' . $before_year . '1231') !== false) :
						?>
							<div class="pdf">
								<iframe src="<?php echo esc_url($pdf_url); ?>"></iframe>
							</div>
						<?php endif; ?>
					<?php else : //20日以降 
					?>
						<!-------------------------20日締めの請求書は1月分、月末締めの請求書は12月の請求書を表示----------------------------------->

						<?php if (strpos($pdf_url,  '_' . $now_year . '0120') !== false || strpos($pdf_url,  '_' . $before_year . '1231') !== false) :
						?>
							<div class="pdf">
								<iframe src="<?php echo esc_url($pdf_url); ?>"></iframe>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php else : //1月以外の時 
				?>
					<?php if (date('d') > 0 && date('d') < 20) : //1日～19日の時 
					?>
						<!-------------------------20日締めの請求書も、月末締めの請求書も、前月の請求書を表示----------------------------------->
						<?php if (strpos($pdf_url,  '_' . $now_year . $before_month_data . '20') !== false || strpos($pdf_url, '_' . $now_year . $before_month_data . $before_month_lastday) !== false) :
						?>
							<div class="pdf">
								<iframe src="<?php echo esc_url($pdf_url); ?>"></iframe>
							</div>
						<?php endif; ?>
					<?php else : //20日以降 
					?>
						<!-------------------------20日締めの請求書は当月分、月末締めの請求書は前月分を表示----------------------------------->
						<?php if (strpos($pdf_url,  '_' . $now_year . $now_month_data . '20') !== false || strpos($pdf_url, '_' . $now_year . $before_month_data . $before_month_lastday) !== false) :
						?>
							<div class="pdf">
								<iframe src="<?php echo esc_url($pdf_url); ?>"></iframe>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
	<?php
		endwhile;
	endif;
	wp_reset_query();
	?>
	<div class="archive">
		<p>＜過去の請求書一覧（1年分）＞</p>
		<?php
		for ($year = date('Y'); $year > $now_year - 2; $year--) :
		?>
			<p><?php echo esc_html($year); ?>年</p>
			<?php if ($year == $now_year) : //今年の表示方法 
			?>
				<?php for ($month = $now_month - 1; $month > 0; $month--) : ?>
					<div>
						<?php
						if ($the_query->have_posts()) :
							while ($the_query->have_posts()) :
								$the_query->the_post();
								$pdf_url = wp_get_attachment_url($the_query->post->ID); //メディアのURLを返す
						?>
								<?php if (strpos($pdf_url, $user_number . '-')) : ?>
									<?php if (strpos($pdf_url, '_' . $year . str_pad($month, 2, 0, STR_PAD_LEFT)) && strpos($pdf_url, '-0')) : ?>
										<a href="<?php echo esc_html($pdf_url); ?>" target="_blank"><?php echo esc_html($month); ?>月(振込)</a>
									<?php elseif (strpos($pdf_url, '_' . $year . str_pad($month, 2, 0, STR_PAD_LEFT)) && !strpos($pdf_url, '-0')) : ?>
										<a href="<?php echo esc_html($pdf_url); ?>" target="_blank"><?php echo esc_html($month); ?>月(引落)</a>
									<?php endif; ?>
								<?php endif; ?>
						<?php endwhile;
						endif; ?>
					</div>
				<?php endfor; ?>

			<?php elseif ($year !== $now_year) : //去年の表示方法 
			?>
				<?php for ($month = 12; $month >= $now_month; $month--) : ?>
					<?php if ($the_query->have_posts()) :
						while ($the_query->have_posts()) :
							$the_query->the_post();
							$pdf_url = wp_get_attachment_url($the_query->post->ID); //メディアのURLを返す
					?>
							<?php if (strpos($pdf_url, $user_number . '-')) : ?>
								<?php if (strpos($pdf_url,  '_' . $year . str_pad($month, 2, 0, STR_PAD_LEFT)) && strpos($pdf_url, '-0')) : ?>
									<a href="<?php echo esc_html($pdf_url); ?>" target="_blank"><?php echo esc_html($month); ?>月(振込)</a>
								<?php elseif (strpos($pdf_url, '_' . $year . str_pad($month, 2, 0, STR_PAD_LEFT)) && !strpos($pdf_url, '-0')) : ?>
									<a href="<?php echo esc_html($pdf_url); ?>" target="_blank"><?php echo esc_html($month); ?>月(引落)</a>
								<?php endif; ?>
							<?php endif; ?>
					<?php endwhile;
					endif; ?>
				<?php endfor; ?>
			<?php endif; ?>
		<?php
		endfor; //年のループ終わり
		?>
	</div>
</div><!-- .entry-content -->
<?php get_footer(); ?>