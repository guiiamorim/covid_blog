<!--<div class="cover" style="background-image: url('<?= PATH ?>/public/img/bg.jpg')"></div>-->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 relative">
			<div class="w-full bg-white mx-auto p-3">
				<div class="row">
                    <div class="col-md-12 my-6">
                        <h1 class="text-3xl">Editar post</h1>
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
                    
                    <div class="col-md-12">
                        <form action="<?= PATH ?>/post/update" method="post" enctype="multipart/form-data"
                              id="postCreate">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group text-gray-700">
                                        <label for="titulo" class="text-gray-700">Título</label>
                                        <input type="text" name="titulo" id="titulo" class="rounded-md border
                    border-gray-700 w-full h-10 p-6" placeholder="" required value="<?= $post->getTitulo() ?>">
                                        <input type="hidden" name="id" value="<?= $post->getId() ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-gray-700">
                                        <label for="tags" class="text-gray-700">Tags</label>
                                        <select name="tags[]" id="tags" class="choices-select-fetch rounded-md border
                    border-gray-700 w-full h-10 p-6" data-choices="<?= PATH . '/tag/list' ?>" data-selected="<?= implode(',',
											array_map(fn($t) => $t->getId(), $tags)) ?>"
                                                data-create="<?= PATH . '/tag/store' ?>" required multiple>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group text-gray-700">
                                        <label for="categorias" class="text-gray-700">Categorias</label>
                                        <select name="categorias[]" id="categorias" class="choices-select rounded-md
                                        border border-gray-700 w-full h-10 p-6" data-selected="<?= implode(',',
											array_map(fn($c) => $c->getCategoriaPost()->getId(), $catP)) ?>" required
                                                multiple>
											<?php if (!empty($categorias)): ?>
												<?php foreach ($categorias as $c): ?>
                                                    <option value="<?= $c->getId() ?>"><?= $c->getNome() ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group text-gray-700">
                                        <label for="texto" class="text-gray-700">Texto</label>
                                        <textarea name="texto" id="texto" class="tinymce" placeholder="" rows="25"
                                                  required><?= $post->getTexto() ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="text-gray-700">Capa do post</span>
                                        <label for="capa" class="rounded-md border
                                        border-gray-700 w-full px-6 py-3 text-gray-700"><?= array_reduce(explode("/",
                                                $post->getCapa()), fn($r, $v) => $r .= strpos($v, ".") != -1 ? $v :
                                                "", "")
                                            ?></label>
                                        <input type="file" name="capa" id="capa" class="hidden">
                                    </div>
                                </div>
                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="p-3 bg-green-600 text-white text-lg
                                    rounded">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>