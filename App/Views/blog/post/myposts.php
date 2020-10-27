<!--<div class="cover" style="background-image: url('<?= PATH ?>/public/img/bg.jpg')"></div>-->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 relative">
			<div class="w-full mx-auto p-3">
				<div class="row">
                    <div class="col-md-12 my-6">
                        <h1 class="text-3xl">Meus posts</h1>
                    </div>
					
					<?php if ($Sessao::retornaMensagem()): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?= $Sessao::retornaMensagem() ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
					
					<?php elseif ($Sessao::retornaErro()): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?= $Sessao::retornaErro() ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
					<?php endif; $Sessao::limpaErro(); $Sessao::limpaMensagem() ?>
                    
                    <?php foreach ($posts as $post):?>
                        <div class="w-8/12 flex mx-auto shadow rounded overflow-hidden relative">
                            <div class="w-64 mr-3">
                                <img src="<?= PATH . '/public/img/posts/' . $post->getCapa() ?>" alt="">
                            </div>
                            <div class="flex flex-col flex-grow justify-between px-3">
                                <a href="<?= PATH . '/post/edit/' . $post->getId() ?>" class="absolute
                                top-0 right-0 p-2" title="Editar post">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <h2 class="text-xl font-semibold"><?= $post->getTitulo() ?></h2>
                                <div>
                                    <span class="block">Data de publicação: <?= $post->getDataCriacao()->format('d/m/Y')
										?></span>
                                    <span class="block">Categorias: <?= implode("",
											array_map(fn($c) => "<span class='p-1 rounded bg-gray-300 m-1'>{$c->getCategoriaPost()->getNome()}</span>",
												$post->getPostCategoriasJoinCategoriaPost()->getData())) ?></span>
                                    <span class="block">Tags: <?= implode("",
											array_map(fn($t) => "<span class='p-1 rounded bg-gray-300 m-1'>{$t->getNome()}</span>",
												$tags[$post->getId()])) ?></span>
                                </div>
                                <div class="w-full flex justify-between mt-auto mb-0">
                                    <span>Status: <?= $post->getStatus() ?></span>
                                    <span title="visualizações"><i class="fas fa-eye"></i> <?=
                                        $post->getVisualizacoes()
                                        ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
			</div>
		</div>
	</div>
</div>