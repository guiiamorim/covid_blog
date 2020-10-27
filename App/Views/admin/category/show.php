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

<div class="bg-white pb-4 px-4 rounded-sm w-full shadow-sm">
    <div class="flex justify-between w-full pt-6 ">
        <h3 class="ml-3">Editar Categoria</h3>
    </div>
    <div class="mt-6">
        <form action="<?= PATH ?>/category/update/<?=$categoria->getId()?>" method="post">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" class="rounded-md border
                     w-full h-10 p-6" placeholder="" required value="<?=
						$Sessao::retornaFormulario('CategoryController', 'edicao')['nome'] ?? $categoria->getNome() ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" class="rounded-md border
                     w-full h-12 px-6 bg-transparent pointer-events-none" required>
                            <option value="post" <?= $categoria instanceof App\Models\CategoriaPost ? 'selected' : 'disabled'
                            ?>>Postagem</option>
                            <option value="report" <?= $categoria instanceof App\Models\CategoriaReport ? 'selected'
                                : 'disabled'
							?>>Denúncia</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" class="rounded-md border
                     w-full p-2" placeholder="" required><?=
							$Sessao::retornaFormulario('CategoryController', 'edicao')['descricao'] ??
                            $categoria->getDescricao()
                            ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 ml-auto text-right">
                    <button type="submit" class="px-4 py-2 rounded-md bg-green-500 text-white
                    text-xl">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>