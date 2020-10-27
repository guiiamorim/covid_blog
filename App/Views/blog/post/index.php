<div class="cover" style="background-image: url('<?= PATH ?>/public/img/bg.jpg')"></div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 bg-white relative">
			<div class="w-full mx-auto p-3">
				<div class="row">
                    <div class="col-md-8">
                        <?php if (!empty($post)): ?>
                        <article>
                            <div class="post-header">
                                <h1 class="text-4xl"><?= $post->getTitulo() ?></h1>
                            </div>
                            <div class="author-info flex items-center gap-2 text-black my-3">
                                <div class="img-preview h-8 w-8 pointer-events-none">
                                    <img src="<?= PATH . '/public/img/profile/' . $autores[$post->getId()]->getFoto() ??
                                    'covid.svg' ?>"
                                         alt="">
                                </div>
                                <span class="author-name"><?= $autores[$post->getId()]->getNome() ?></span> -
                                <span class="published-at"><?= $post->getDataCriacao()->format('d/m/Y') ?></span>
                            </div>
                            <div class="post-cover">
                                <img src="<?= PATH . '/public/img/posts/' . $post->getCapa() ?>" class="w-full" alt="">
                            </div>
                            <div class="post-content mt-4">
                                <?= $post->getTexto() ?>
                            </div>
                        </article>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 md:border-l">
                        <aside>
                            <h3 class="text-xl">Últimas postagens</h3>
                            <div class="w-full flex flex-col">
                                <div class="post-thumb">
                                    <img src="<?= PATH ?>/public/img/bg.jpg" alt="">
                                    <div class="post-info">
                                        <h5 class="text-lg">Cura do Covid-19</h5>
                                        <span>Testes recentes confirmam que a cloroquina...</span>
                                    </div>
                                </div>
                                <div class="post-thumb">
                                    <img src="<?= PATH ?>/public/img/bg.jpg" alt="">
                                    <div class="post-info">
                                        <h5>Cura do Covid-19</h5>
                                        <span>Testes recentes confirmam que a cloroquina...</span>
                                    </div>
                                </div>
                                <div class="post-thumb">
                                    <img src="<?= PATH ?>/public/img/bg.jpg" alt="">
                                    <div class="post-info">
                                        <h5>Cura do Covid-19</h5>
                                        <span>Testes recentes confirmam que a cloroquina...</span>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>