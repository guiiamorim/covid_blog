<div class="wrapper d-flex align-items-stretch">
	<nav id="sidebar">
		<div class="p-4 pt-5">
			<a href="<?= PATH ?>/user/profile" class="img logo rounded-circle mb-5" style="background-image: url(<?=
            PATH . '/public/img/profile/' . ($Sessao::retornaLogin()
                ->getFoto() ?? 'covid.svg')
			        ?>);"></a>
			<ul class="list-unstyled components mb-5">
				<li id="category">
					<a href="#categoriasSubmenu" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Categorias</a>
					<ul class="collapse list-unstyled" id="categoriasSubmenu">
						<li>
							<a href="<?= PATH ?>/category/create">Cadastrar categoria</a>
						</li>
						<li>
							<a href="<?= PATH ?>/category/post">Gerenciar categorias (postagens)</a>
						</li>
                        <li>
                            <a href="<?= PATH ?>/category/report">Gerenciar categorias (denúncias)</a>
                        </li>
					</ul>
				</li>
				<li id="moderator">
					<a href="#moderadorSubmenu" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Moderadores</a>
					<ul class="collapse list-unstyled" id="moderadorSubmenu">
						<li>
							<a href="<?= PATH ?>/user/create/moderator">Cadastrar moderador</a>
						</li>
						<li>
							<a href="<?= PATH ?>/user/moderator">Gerenciar Moderadores</a>
						</li>
					</ul>
				</li>
                <li id="comunity">
                    <a href="#comunidadeSubmenu" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Comunidades</a>
                    <ul class="collapse list-unstyled" id="comunidadeSubmenu">
                        <li>
                            <a href="<?= PATH ?>/comunity/create">Cadastrar Comunidade</a>
                        </li>
                        <li>
                            <a href="<?= PATH ?>/comunity">Gerenciar Comunidades</a>
                        </li>
                    </ul>
                </li>
                <li id="reports">
                    <a href="#relatorioSubmenu" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Relatórios</a>
                    <ul class="collapse list-unstyled" id="relatorioSubmenu">
                        <li>
                            <a href="<?= PATH ?>/reports/views">Notícias mais visualizadas</a>
                        </li>
                    </ul>
                </li>
                <li id="backup">
                    <a href="#backupSubmenu" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">Backup</a>
                    <ul class="collapse list-unstyled" id="backupSubmenu">
                        <li>
                            <a href="<?= PATH ?>/user/create/moderator">Cadastrar moderador</a>
                        </li>
                        <li>
                            <a href="<?= PATH ?>/user/moderator">Gerenciar Moderadores</a>
                        </li>
                    </ul>
                </li>
			</ul>
		
		</div>
	</nav>
	
	<!-- Page Content  -->
	<div id="content" class="p-4 p-md-5 bg-gray-200 overflow-y-auto max-h-screen">
		
		<nav class="navbar navbar-expand-lg navbar-light bg-white">
			<div class="container-fluid">
				
				<button type="button" id="sidebarCollapse" class="btn btn-primary">
					<i class="fas fa-bars"></i>
					<span class="sr-only">Toggle Menu</span>
				</button>
				
                <h1 class="font-semibold text-2xl ml-3 inline-flex items-center">
                    <img src="<?= PATH . '/public/img/profile/covid.svg' ?>"
                         class="w-12 h-12 mr-2">
                    Covid News
                </h1>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="nav navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link" href="<?= PATH ?>/" target="_blank">Blog <i class="fas fa-arrow-right"></i></a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		