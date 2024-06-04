const modal = document.querySelector('.modal-container')
const tbody = document.querySelector('tbody')
const sCodigoAnomalia = document.querySelector('#m-codigo-anomalia')
const sLocalAnomalia = document.querySelector('#m-local-anomalia')
const sTecnica = document.querySelector('#m-tecnica')
const sStatus = document.querySelector('#m-status')
const sIntervencaoRecomendada = document.querySelector('#m-intervencao-recomendada')
const sDescricaoAnomalia = document.querySelector('#m-descricao-anomalia')
const sFotoEquipamento = document.querySelector('#m-foto-equipamento')
const btnSalvar = document.querySelector('#btnSalvar')

let itens
let id

function openModal(edit = false, index = 0) {
  modal.classList.add('active')

  modal.onclick = e => {
    if (e.target.className.indexOf('modal-container') !== -1) {
      modal.classList.remove('active')
    }
  }

  if (edit) {
    sCodigoAnomalia.value = itens[index].codigoAnomalia
    sLocalAnomalia.value = itens[index].localAnomalia
    sTecnica.value = itens[index].tecnica
    sStatus.value = itens[index].status
    sIntervencaoRecomendada.value = itens[index].intervencaoRecomendada
    sDescricaoAnomalia.value = itens[index].descricaoAnomalia
    sFotoEquipamento.value = itens[index].fotoEquipamento
    id = index
  } else {
    sCodigoAnomalia.value = ''
    sLocalAnomalia.value = ''
    sTecnica.value = ''
    sStatus.value = ''
    sIntervencaoRecomendada.value = ''
    sDescricaoAnomalia.value = ''
    sFotoEquipamento.value = ''
  }
  
}

function editItem(index) {
  openModal(true, index)
}

function deleteItem(index) {
  itens.splice(index, 1)
  setItensBD()
  loadItens()
}

function insertItem(item, index) {
  let tr = document.createElement('tr')

  tr.innerHTML = `
    <td>${item.codigoAnomalia}</td>
    <td>${item.localAnomalia}</td>
    <td>${item.tecnica}</td>
    <td>${item.status}</td>
    <td>${item.intervencaoRecomendada}</td>
    <td>${item.descricaoAnomalia}</td>
    <td>${item.fotoEquipamento}</td>
    <td class="acao">
      <button onclick="editItem(${index})"><i class='bx bx-edit' ></i></button>
    </td>
    <td class="acao">
      <button onclick="deleteItem(${index})"><i class='bx bx-trash'></i></button>
    </td>
    <td class="acao">
      <a href="#" onclick="downloadPDF(${index})">Baixar PDF</a>
    </td>
  `
  tbody.appendChild(tr)
}

btnSalvar.onclick = e => {
  
  if (sCodigoAnomalia.value == '' || sLocalAnomalia.value == '' || sTecnica.value == '' || sStatus.value == '' || 
  sIntervencaoRecomendada.value == '' || sDescricaoAnomalia.value == '' || sFotoEquipamento.value == '') {
    return
  }

  e.preventDefault();

  if (id !== undefined) {
    itens[id].codigoAnomalia = sCodigoAnomalia.value
    itens[id].localAnomalia = sLocalAnomalia.value
    itens[id].tecnica = sTecnica.value
    itens[id].status = sStatus.value
    itens[id].intervencaoRecomendada = sIntervencaoRecomendada.value
    itens[id].descricaoAnomalia = sDescricaoAnomalia.value
    itens[id].fotoEquipamento = sFotoEquipamento.value
  } else {
    itens.push({'codigoAnomalia': sCodigoAnomalia.value, 'localAnomalia': sLocalAnomalia.value, 
    'tecnica': sTecnica.value, 'status': sStatus.value, 'intervencaoRecomendada': sIntervencaoRecomendada.value, 
    'descricaoAnomalia': sDescricaoAnomalia.value, 'fotoEquipamento': sFotoEquipamento.value})
  }

  setItensBD()

  modal.classList.remove('active')
  loadItens()
  id = undefined
}

function loadItens() {
  itens = getItensBD()
  tbody.innerHTML = ''
  itens.forEach((item, index) => {
    insertItem(item, index)
  })

}

const getItensBD = () => JSON.parse(localStorage.getItem('dbfunc')) ?? []
const setItensBD = () => localStorage.setItem('dbfunc', JSON.stringify(itens))

function downloadPDF(index) {
  const item = itens[index];
  
  const content = `
  
  <img src="/Logomarca_Pred_Engenharia-removebg-preview.png" alt="" class="logo">

  <table class="table1">
      <tr>
          <th rowspan="2" style="font-size: 26px;">Relatórios de Anomalia</th>
          <th rowspan="2" style="text-align: left; vertical-align: top;">Técnica:<br><span
                  style="font-size: 20px;">Sensitiva</span></th>
          <th rowspan="2" style="text-align: left; vertical-align: top;">Status:<br><span
                  style="font-size: 20px;">Pendente</span></th>
      </tr>

  </table>
  <div class="title">Local da anomalia</div>
  <div class="content">
      <div>${item.localAnomalia}</div>
      
  </div>
  <div class="title">Descreção da anomalia</div>
  <div class="content">
      <div>${item.descricaoAnomalia}</div>
  </div>
  <div class="title">Avaliação da anomalia</div><br><br><br><br><br><br><br><br><br><br><br><br>
  <div class="title">Intervenção recomendada</div>
  <div class="content">
      <div>${item.intervencaoRecomendada}</div>
  </div>

  <div class="title-2">Fotografia do equipamento</div>
  <img src="${item.fotoEquipamento}" alt="" class="quadrado">
  <div class="title-3">Fotografia pós-reparo</div>
  <div class="quadrado-1"></div>
  <div class="quadrado-2">
      <div class="content-1">
          <div>Comentários pós-manutenção</div>
      </div>
  </div>
  <div class="quadrado-3"></div>

  <div class="content-2">
      <div>DM253® - Todos os direitos reservados a Pred Engenharia Ltda.</div>
  </div>
  `;

  // Criar um elemento div temporário
  const tempDiv = document.createElement('div');
  tempDiv.innerHTML = content;

  // Converter o conteúdo em PDF usando a biblioteca html2pdf
  html2pdf().from(tempDiv).save();
}

loadItens()