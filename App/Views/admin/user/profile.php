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
        <h3 class="ml-3">Meu Perfil</h3>
    </div>
    <div class="mt-6">
        <form action="<?= PATH . '/user/update/' . $usuario->getId() ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="tipo" id="tipo" value="profile">
            <div class="form-row">
                <div class="col-md-12 text-center">
                    <div class="img-preview shadow-md mx-auto">
                        <img src="<?= PATH . '/public/img/profile/' . ($usuario->getFoto() ?? 'covid.svg') ?>" class="profile-pic"
                             alt="">
                        <input type="file" name="foto" id="foto" accept="image/jpeg">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" class="rounded-md border
                     w-full h-10 p-6" placeholder="João da Silva" required value="<?=
						$Sessao::retornaFormulario('LoginController', 'cadastro')['nome'] ?? $usuario->getNome() ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="rounded-md border
                     w-full h-10 p-6" placeholder="joao@provedor.com" required value="<?=
						$Sessao::retornaFormulario('LoginController', 'cadastro')['email'] ?? $usuario->getEmail() ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="phone rounded-md border
                     w-full h-10 p-6" placeholder="(xx) xxxxx-xxxx" required value="<?=
						$Sessao::retornaFormulario('LoginController', 'cadastro')['telefone'] ??
						$usuario->getTelefone() ?>">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <?php if ($usuario->getTipo() == 'usr'): ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="idComunidade">Comunidade</label>
                        <select name="idComunidade" id="idComunidade" class="rounded-md border
                     w-full h-12 px-6 bg-transparent" required>
                            <option value=""></option>
							<?php foreach ($comunidades as $comunidade): ?>
                                <option value="<?= $comunidade->getId() ?>" <?= $comunidade->getId() ==
								$usuario->getIdComunidade() ? 'selected' : '' ?>><?=
									$comunidade->getNome()
									?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" class="rounded-md border
                     w-full h-10 p-6">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="senha2">Digite a senha novamente</label>
                        <input type="password" name="senha2" id="senha2" class="rounded-md border
                     w-full h-10 p-6">
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