<div class="row">
	<div class="col-sm-8">
		<div class="card m-b-30">
            <div class="card-header">
               <div class="title"><?= __('admin.system_status_help_line') ?></div>
            </div>
			<div class="card-body p-0" style="overflow: auto;">
                <div class="system-status">
                    <div class="<?= array_key_exists('php', $serverReq) ? 'error' : 'success' ?>" >
                        <div><?= __('admin.php_version') ?></div>
                        <div><?= __('admin.minimum_php_version') ?> 7.2</div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= array_key_exists('curl', $serverReq) ? 'error' : 'success' ?>" >
                        <div><?= __('admin.curl') ?></div>
                        <div><?= __('admin.extension') ?> <i>php_curl</i></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= array_key_exists('openssl_encrypt', $serverReq) ? 'error' : 'success' ?>" >
                        <div><?= __('admin.openssl_encrypt') ?></div>
                        <div><?= __('admin.extension') ?> <i>openssl_encrypt</i></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= array_key_exists('mysqli', $serverReq) ? 'error' : 'success' ?>" >
                        <div><?= __('admin.mysqli') ?></div>
                        <div><?= __('admin.extension') ?> <i>mysqli</i></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= array_key_exists('ipapi', $serverReq) ? 'error' : 'success' ?>" >
                        <div><?= __('admin.ip_api') ?></div>
                        <div><?= __('admin.extension') ?> <i>php_curl</i></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= array_key_exists('ziparchive', $serverReq) ? 'error' : 'success' ?>" >
                        <div><?= __('admin.zip_archive') ?></div>
                        <div><?= __('admin.extension') ?> <i>zip</i></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= isset($serverReq['allow_url_fopen']) ? 'error' : 'success' ?>" >
                        <div>allow_url_fopen</div>
                        <div><?= __('admin.php_ini') ?> <i> allow_url_fopen</i></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
                    <div class="<?= is_ssl() ? 'success' : 'error' ?>" >
                        <div><?= is_ssl() ? __('admin.ssl') : __('admin.non_ssl') ?></div>
                        <div><?= __('admin.install') ?> <i><?= __('admin.ssl') ?></i> <?= __('admin.certificate') ?></div>
                        <div><i class="fa fa-icon"></i></div>
                    </div>
					<div class="<?= extension_loaded('gd') ? 'success' : 'error'; ?>" >
						<div><?= extension_loaded('gd') ? __('admin.gd_library_installed') : __('admin.no_gd_library_installed'); ?></div>
						<div><?= __('admin.install') ?> <i><?= __('admin.gd') ?></i> <?= __('admin.library') ?></div>
						<div><i class="fa fa-icon"></i></div>
					</div>
                </div>
			</div>
		</div> 
	</div> 

	<div class="col-sm-4">
		<div class="card m-b-30">
            <div class="card-header">
               <div class="title"><?= __('admin.system_information_help_line') ?></div>
            </div>
			<div class="card-body p-0" style="overflow: auto;">
				<div class="system-status">
					<div>
						<div><?= __('admin.server_php_version') ?></div>
						<div><?= phpversion() ?></div>
					</div>
                    <div>
                    	<div><?= __('admin.server_database_version') ?></div>
                    	<div><?= database_version() ?></div>
                	</div>
                	<div>
                    	<div><?= __('admin.server_database_software') ?></div>
                    	<div><?= database_software() ?></div>
                	</div>

                	<div>
                    	<div><?= __('admin.server_system_os') ?></div>
                    	<div><?= server_os() ?></div>
                	</div>
                	<div>
                    	<div><?= __('admin.server_memory_limit') ?></div>
                    	<div><?= check_limit() ?></div>
                	</div>
                	<div>
                    	<div><?= __('admin.server_ip') ?></div>
                    	<div><?= check_server_ip() ?></div>
                	</div>
                	<div>
                    	<div><?= __('admin.server_max_file_upload_size') ?></div>
                    	<div><?= php_max_upload_size() ?></div>
                	</div>
                	<div>
                    	<div><?= __('admin.server_post_variable_size') ?></div>
                    	<div><?= php_max_post_size() ?></div>
                	</div>
                	<div>
                    	<div><?= __('admin.server_max_execution_time') ?></div>
                    	<div><?= php_max_execution_time() ?></div>
                	</div>
				</div>
			</div>
		</div> 
	</div> 
</div>

