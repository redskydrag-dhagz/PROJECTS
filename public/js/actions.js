var url = "http://inventoryselco.eu.pn/post/deleted";

function delete_items(value){
    $.post(url,{itemcode:value},function(echo){
        return echo;
    });
}

function search_items(item){
    $.post(url,{ itemcode :item },function(echo){
       return echo;     
    });
}