export class Router {
    constructor(_selector){
       this.selector = _selector;
    }

    get(url, callback){
        this.selector.load("views/" + url + ".php", callback);
    }

}

