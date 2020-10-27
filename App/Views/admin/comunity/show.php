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
        <h3 class="ml-3">Editar Comunidade</h3>
    </div>
    <div class="mt-6">
        <form action="<?= PATH . '/comunity/update/' . $comunidade->getId() ?>" method="post">
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" class="rounded-md border
                     w-full h-10 p-6" placeholder="João da Silva" required value="<?=
						$Sessao::retornaFormulario('ComunityController', 'edicao')['nome'] ?? $comunidade->getNome()
                        ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="" id="estado" class="rounded-md border  w-full h-12 px-6
                        bg-transparent">
                            <option value=""></option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="idComunidade">Cidade</label>
                        <select name="idCidade" id="idCidade" class="rounded-md border
                     w-full h-12 px-6 bg-transparent" required>
                            <option value=""></option>
							<?php $c = $Sessao::retornaFormulario('ComunityController', 'edicao')['idCidade'] ??
								$comunidade->getIdCidade() ?>
							<?php foreach ($cidades as $cidade): ?>
                                <option value="<?= $cidade->getId() ?>" <?= $cidade->getId() == $c ? 'selected' : ''
								?>><?=
									$cidade->getNome()
									?></option>
							<?php endforeach; ?>
                        </select>
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