var url = '';

//Pega a url da página atual e atribui à variável url para ser usada nos header
function setPage()
{
    url = window.location.href;
    document.getElementById('page').value = url;
}