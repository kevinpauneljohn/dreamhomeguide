const searchPropertyFullForm = $('#full-search-property-form');
const resetSearchButton = $('#reset-search');

resetSearchButton.on('click', () => {
    removeUrlParameters();
    clearSearchForm();
})

const removeUrlParameters = () => {
    const url = window.location.origin + window.location.pathname;
    window.history.replaceState({}, '', url);
}

const clearSearchForm = () => {
    searchPropertyFullForm.find('input, select').each(function(){
        let element = $(this).attr('name');
        if($(this).attr('name') !== '_token')
        {
            searchPropertyFullForm.find(`#${element}`).val('').change();
        }
    })
}
