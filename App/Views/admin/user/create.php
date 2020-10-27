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
        <h3 class="ml-3">Cadastrar Usuário</h3>
    </div>
    <div class="mt-6">
        <form action="<?= PATH ?>/user/store" method="post">
            <input type="hidden" name="tipo" id="tipo" value="<?= $tipo ?>">
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" class="rounded-md border
                     w-full h-10 p-6" placeholder="João da Silva" required value="<?=
						$Sessao::retornaFormulario('UserController', 'cadastro')['nome'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="rounded-md border
                     w-full h-10 p-6" placeholder="joao@provedor.com" required value="<?=
						$Sessao::retornaFormulario('UserController', 'cadastro')['email'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="phone rounded-md border
                     w-full h-10 p-6" placeholder="(xx) xxxxx-xxxx" value="<?=
						$Sessao::retornaFormulario('UserController', 'cadastro')['telefone'] ?? '' ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="idComunidade">Comunidade</label>
                        <select name="idComunidade" id="idComunidade" class="rounded-md border
                     w-full h-12 px-6 bg-transparent" required>
                            <option value=""></option>
							<?php $c = $Sessao::retornaFormulario('UserController', 'cadastro')['idComunidade'] ?? '' ?>
							<?php foreach ($comunidades as $comunidade): ?>
                                <option value="<?= $comunidade->getId() ?>" <?= $comunidade->getId() == $c ? 'selected' : '' ?>><?=
                                    $comunidade->getNome()
                                    ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" class="rounded-md border
                     w-full h-10 p-6" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="senha2">Digite a senha novamente</label>
                        <input type="password" name="senha2" id="senha2" class="rounded-md border
                     w-full h-10 p-6" required>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-12 ml-auto text-right">
                    <button type="submit" class="px-4 py-2 rounded-md bg-green-500 text-white
                    text-xl">Salvar</button>
                </div>
            </div>
    </div>
</div>
<script>
    // const userType = document.getElementById('tipo')
    // if (userType != 'user') {
    //     const c = document.getElementById('idComunidade');
    //     c.classList.remove('bg-transparent')
    //     c.setAttribute('disabled', true);
    // }
</script>