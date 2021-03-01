<div class="innerRightActions">
		<div class="pull-right">
			<?php
				if (!empty($potentialList) && sizeof($potentialList) > 1) 
			{ ?>
				<div class="filters-action">
					<select class="js-example-basic-single sites-list form-control" name="state" data-allow-clear="true" id="usersites">
						<option disabled selected>Select Site</option>
						<?php
						$i = 0;
						foreach ($potentialList as $site) {

						?>
						<option value="<?php echo $i; ?>" <?Php if ($selectedSite['siteName'] == $site['siteName']) { ?>selected<?php } ?>><?php echo $site['siteName']; ?></option>
						<?php $i++;
					} ?>
					</select>
				</div>
			<?php }?>
			<?php if (isset($isLiveViews) && $isLiveViews === true) { ?>
				<div class="count-site">
					<a href="javascript:void(0)" data-show="1" class="display-type liveOne">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 585.926 585.926">
						<path id="Path_149" data-name="Path 149" d="M0,58.592A58.592,58.592,0,0,1,58.593,0h468.74a58.593,58.593,0,0,1,58.593,58.593v468.74a58.593,58.593,0,0,1-58.593,58.593H58.592A58.592,58.592,0,0,1,0,527.333Z" fill="#d8d8d8" />
						</svg>
					</a>
					<a href="javascript:void(0)" data-show="2" class="display-type liveTwo">
						<svg id="noun_grid_2613416" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 585.926 585.926">
							<path id="Path_136" data-name="Path 136" d="M0,26.041A26.041,26.041,0,0,1,26.041,0H234.37a26.041,26.041,0,0,1,26.041,26.041V234.37a26.041,26.041,0,0,1-26.041,26.041H26.041A26.041,26.041,0,0,1,0,234.37Z" fill="#d8d8d8" />
							<path id="Path_137" data-name="Path 137" d="M33.333,26.041A26.041,26.041,0,0,1,59.375,0H267.7a26.041,26.041,0,0,1,26.042,26.041V234.37A26.041,26.041,0,0,1,267.7,260.412H59.375A26.041,26.041,0,0,1,33.333,234.37Z" transform="translate(292.181)" fill="#d8d8d8" />
							<path id="Path_138" data-name="Path 138" d="M33.333,59.375A26.041,26.041,0,0,1,59.375,33.333H267.7a26.041,26.041,0,0,1,26.042,26.041V267.7A26.041,26.041,0,0,1,267.7,293.745H59.375A26.041,26.041,0,0,1,33.333,267.7Z" transform="translate(292.181 292.181)" fill="#d8d8d8" />
							<path id="Path_139" data-name="Path 139" d="M0,59.375A26.041,26.041,0,0,1,26.041,33.333H234.37a26.041,26.041,0,0,1,26.041,26.041V267.7a26.041,26.041,0,0,1-26.041,26.042H26.041A26.041,26.041,0,0,1,0,267.7Z" transform="translate(0 292.181)" fill="#d8d8d8" />
						</svg>
					</a>
					<a href="javascript:void(0)" data-show="multi" class="activeGrid display-type liveThree">
						<svg id="noun_grid_2395394" xmlns="http://www.w3.org/2000/svg" width="25" height="18" viewBox="0 0 89.015 65">
						<g id="Group_176" data-name="Group 176" transform="translate(0 0)">
						<g id="Group_159" data-name="Group 159">
						<rect id="Rectangle_55" data-name="Rectangle 55" width="14.748" height="14.748" transform="translate(1.38 1.38)" fill="#d8d8d8" />
						<g id="Group_158" data-name="Group 158">
						<path id="Path_140" data-name="Path 140" d="M61.835,60.441H47.094l1.394,1.394V47.094l-1.394,1.394H61.835l-1.394-1.394V61.835a1.394,1.394,0,1,0,2.788,0V47.094A1.416,1.416,0,0,0,61.835,45.7H47.094A1.416,1.416,0,0,0,45.7,47.094V61.835a1.416,1.416,0,0,0,1.394,1.394H61.835a1.394,1.394,0,0,0,0-2.788Z" transform="translate(-45.7 -45.7)" fill="#d8d8d8" />
						</g>
						</g>
						<g id="Group_161" data-name="Group 161" transform="translate(23.739)">

						<rect id="Rectangle_56" data-name="Rectangle 56" width="14.748" height="14.748" transform="translate(1.387 1.38)" fill="#d8d8d8" />

						<g id="Group_160" data-name="Group 160" transform="translate(0)">

						<path id="Path_141" data-name="Path 141" d="M402.435,60.441H387.694l1.394,1.394V47.094l-1.394,1.394h14.741l-1.394-1.394V61.835a1.394,1.394,0,1,0,2.788,0V47.094a1.416,1.416,0,0,0-1.394-1.394H387.694a1.416,1.416,0,0,0-1.394,1.394V61.835a1.416,1.416,0,0,0,1.394,1.394h14.741a1.394,1.394,0,0,0,0-2.788Z" transform="translate(-386.3 -45.7)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_163" data-name="Group 163" transform="translate(47.485)">

						<rect id="Rectangle_57" data-name="Rectangle 57" width="14.748" height="14.748" transform="translate(1.38 1.38)" fill="#d8d8d8" />

						<g id="Group_162" data-name="Group 162">

						<path id="Path_142" data-name="Path 142" d="M743.135,60.441H728.394l1.394,1.394V47.094l-1.394,1.394h14.741l-1.394-1.394V61.835a1.394,1.394,0,1,0,2.788,0V47.094a1.416,1.416,0,0,0-1.394-1.394H728.394A1.416,1.416,0,0,0,727,47.094V61.835a1.416,1.416,0,0,0,1.394,1.394h14.741a1.394,1.394,0,0,0,0-2.788Z" transform="translate(-727 -45.7)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_188" data-name="Group 188" transform="translate(71.485)">

						<rect id="Rectangle_57-2" data-name="Rectangle 57" width="14.748" height="14.748" transform="translate(1.38 1.38)" fill="#d8d8d8" />

						<g id="Group_162-2" data-name="Group 162">

						<path id="Path_142-2" data-name="Path 142" d="M743.135,60.441H728.394l1.394,1.394V47.094l-1.394,1.394h14.741l-1.394-1.394V61.835a1.394,1.394,0,1,0,2.788,0V47.094a1.416,1.416,0,0,0-1.394-1.394H728.394A1.416,1.416,0,0,0,727,47.094V61.835a1.416,1.416,0,0,0,1.394,1.394h14.741a1.394,1.394,0,0,0,0-2.788Z" transform="translate(-727 -45.7)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_165" data-name="Group 165" transform="translate(0 47.47)">

						<rect id="Rectangle_58" data-name="Rectangle 58" width="14.748" height="14.748" transform="translate(1.38 1.395)" fill="#d8d8d8" />

						<g id="Group_164" data-name="Group 164">

						<path id="Path_143" data-name="Path 143" d="M60.441,728.177v14.741l1.394-1.394H47.094l1.394,1.394V728.177l-1.394,1.394H61.835a1.394,1.394,0,1,0,0-2.788H47.094a1.416,1.416,0,0,0-1.394,1.394v14.741a1.416,1.416,0,0,0,1.394,1.394H61.835a1.416,1.416,0,0,0,1.394-1.394V728.177a1.394,1.394,0,0,0-2.788,0Z" transform="translate(-45.7 -726.782)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_167" data-name="Group 167" transform="translate(0 23.731)">

						<rect id="Rectangle_59" data-name="Rectangle 59" width="14.748" height="14.748" transform="translate(1.38 1.395)" fill="#d8d8d8" />

						<g id="Group_166" data-name="Group 166">

						<path id="Path_144" data-name="Path 144" d="M60.441,387.577v14.741l1.394-1.394H47.094l1.394,1.394V387.577l-1.394,1.394H61.835a1.394,1.394,0,0,0,0-2.788H47.094a1.416,1.416,0,0,0-1.394,1.394v14.741a1.416,1.416,0,0,0,1.394,1.394H61.835a1.416,1.416,0,0,0,1.394-1.394V387.577a1.394,1.394,0,1,0-2.788,0Z" transform="translate(-45.7 -386.182)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_169" data-name="Group 169" transform="translate(47.47 47)">

						<rect id="Rectangle_60" data-name="Rectangle 60" width="14.748" height="14.748" transform="translate(1.395 1.395)" fill="#d8d8d8" />

						<g id="Group_168" data-name="Group 168">

						<path id="Path_145" data-name="Path 145" d="M728.177,729.571h14.741l-1.394-1.394v14.741l1.394-1.394H728.177l1.394,1.394V728.177a1.394,1.394,0,0,0-2.788,0v14.741a1.416,1.416,0,0,0,1.394,1.394h14.741a1.416,1.416,0,0,0,1.394-1.394V728.177a1.416,1.416,0,0,0-1.394-1.394H728.177a1.394,1.394,0,0,0,0,2.788Z" transform="translate(-726.782 -726.782)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_190" data-name="Group 190" transform="translate(71.47 47)">

						<rect id="Rectangle_60-2" data-name="Rectangle 60" width="14.748" height="14.748" transform="translate(1.395 1.395)" fill="#d8d8d8" />

						<g id="Group_168-2" data-name="Group 168">

						<path id="Path_145-2" data-name="Path 145" d="M728.177,729.571h14.741l-1.394-1.394v14.741l1.394-1.394H728.177l1.394,1.394V728.177a1.394,1.394,0,0,0-2.788,0v14.741a1.416,1.416,0,0,0,1.394,1.394h14.741a1.416,1.416,0,0,0,1.394-1.394V728.177a1.416,1.416,0,0,0-1.394-1.394H728.177a1.394,1.394,0,0,0,0,2.788Z" transform="translate(-726.782 -726.782)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_171" data-name="Group 171" transform="translate(23.731 47.47)">

						<rect id="Rectangle_61" data-name="Rectangle 61" width="14.748" height="14.748" transform="translate(1.395 1.395)" fill="#d8d8d8" />

						<g id="Group_170" data-name="Group 170">

						<path id="Path_146" data-name="Path 146" d="M387.577,729.571h14.741l-1.394-1.394v14.741l1.394-1.394H387.577l1.394,1.394V728.177a1.394,1.394,0,0,0-2.788,0v14.741a1.416,1.416,0,0,0,1.394,1.394h14.741a1.417,1.417,0,0,0,1.394-1.394V728.177a1.417,1.417,0,0,0-1.394-1.394H387.577a1.394,1.394,0,1,0,0,2.788Z" transform="translate(-386.182 -726.782)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_173" data-name="Group 173" transform="translate(47.47 24)">

						<rect id="Rectangle_62" data-name="Rectangle 62" width="14.748" height="14.748" transform="translate(1.395 1.387)" fill="#d8d8d8" />

						<g id="Group_172" data-name="Group 172">

						<path id="Path_147" data-name="Path 147" d="M729.571,402.435V387.694l-1.394,1.394h14.741l-1.394-1.394v14.741l1.394-1.394H728.177a1.394,1.394,0,0,0,0,2.788h14.741a1.416,1.416,0,0,0,1.394-1.394V387.694a1.416,1.416,0,0,0-1.394-1.394H728.177a1.416,1.416,0,0,0-1.394,1.394v14.741a1.394,1.394,0,1,0,2.788,0Z" transform="translate(-726.782 -386.3)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_189" data-name="Group 189" transform="translate(71.47 24)">

						<rect id="Rectangle_62-2" data-name="Rectangle 62" width="14.748" height="14.748" transform="translate(1.395 1.387)" fill="#d8d8d8" />

						<g id="Group_172-2" data-name="Group 172">

						<path id="Path_147-2" data-name="Path 147" d="M729.571,402.435V387.694l-1.394,1.394h14.741l-1.394-1.394v14.741l1.394-1.394H728.177a1.394,1.394,0,0,0,0,2.788h14.741a1.416,1.416,0,0,0,1.394-1.394V387.694a1.416,1.416,0,0,0-1.394-1.394H728.177a1.416,1.416,0,0,0-1.394,1.394v14.741a1.394,1.394,0,1,0,2.788,0Z" transform="translate(-726.782 -386.3)" fill="#d8d8d8" />

						</g>

						</g>

						<g id="Group_175" data-name="Group 175" transform="translate(23.739 23.739)">

						<rect id="Rectangle_63" data-name="Rectangle 63" width="14.748" height="14.748" transform="translate(1.387 1.387)" fill="#d8d8d8" />

						<g id="Group_174" data-name="Group 174" transform="translate(0)">

						<path id="Path_148" data-name="Path 148" d="M402.435,401.041H387.694l1.394,1.394V387.694l-1.394,1.394h14.741l-1.394-1.394v14.741a1.394,1.394,0,0,0,2.788,0V387.694a1.417,1.417,0,0,0-1.394-1.394H387.694a1.416,1.416,0,0,0-1.394,1.394v14.741a1.416,1.416,0,0,0,1.394,1.394h14.741a1.394,1.394,0,1,0,0-2.788Z" transform="translate(-386.3 -386.3)" fill="#d8d8d8" />

						</g>

						</g>

						</g>

						</svg>
					</a>
				</div>
			<?php }?>
		</div> <!--end pull-right-->
	</div> <!--end innerRightActions-->
