<div class="w-full h-screen md:flex">
    <div class="md:w-1/2 md:block hidden h-screen bg-blue-100 bg-cover bg-center" style="background-image: url('<?=
    PATH
    ?>/public/img/bg.jpg')
            "></div>
    <div class="md:w-1/2 w-full object-center h-screen md:bg-gray-100 md:overflow-y-scroll">
        <?php if (!empty($Sessao::retornaErro())): ?>
            <div class="w-2/3 mx-auto mt-6 mb-n5 p-6 rounded-md bg-red-400 text-white"><?= $Sessao::retornaErro()
                ?></div>
        <?php $Sessao::limpaErro() ?>
        <?php endif; ?>
        <div class="w-2/3 mx-auto my-12 p-6 md:shadow-md md:bg-white">
            <h1 class="text-5xl text-center mb-6">Cadastro</h1>
            <form action="<?= PATH ?>/login/signUp" method="post">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="rounded-md border
                     w-11/12 h-10 p-6" placeholder="João da Silva" required value="<?=
					$Sessao::retornaFormulario('LoginController', 'cadastro')['nome'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="rounded-md border
                     w-11/12 h-10 p-6" placeholder="joao@provedor.com" required value="<?=
					$Sessao::retornaFormulario('LoginController', 'cadastro')['email'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="phone rounded-md border
                     w-11/12 h-10 p-6" placeholder="(xx) xxxxx-xxxx" required value="<?=
					$Sessao::retornaFormulario('LoginController', 'cadastro')['telefone'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="idComunidade">Comunidade</label>
                    <select name="idComunidade" id="idComunidade" class="rounded-md border
                     w-11/12 h-12 px-6 bg-transparent" required>
                        <option value=""></option>
                        <?php foreach ($comunidades as $comunidade): ?>
                            <option value="<?= $comunidade->getId() ?>"><?= $comunidade->getNome() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="rounded-md border
                     w-11/12 h-10 p-6" required>
                </div>
                <div class="form-group">
                    <label for="senha2">Digite a senha novamente</label>
                    <input type="password" name="senha2" id="senha2" class="rounded-md border
                     w-11/12 h-10 p-6" required>
                </div>
                <button type="submit" class="w-11/12 h-12 my-6 rounded-md bg-green-500 text-white text-xl block
">Criar conta</button>
                <a href="<?= PATH ?>/login" class="text-green-400 mx-auto block hover:text-green-400">Já possui uma
                    conta?
                    Acesse sua conta.</a>
            </form>
        </div>
    </div>
</div>