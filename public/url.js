function url (_base) {
    this.base = _base.replace(/\/+$/,'');
}

url.prototype.configuration = function(uri, server) {
    return this.to('configuration/' + uri, server);
};

url.prototype.page = function(_page, server) {
    return this.to('pages/' + _page + '.html', server);
};

url.prototype.element = function(_element, uri, server) {
    return this.to('element/' + _element + '/' + uri, server);
};

url.prototype.package = function(_package, uri, server) {
    return this.to('package/' + _package + '/' + uri, server);
};

url.prototype.elementView = function(_element, view, server) {

    return this.to('view/element/' + _element + '/' + view, server);
};

url.prototype.packageView = function(_package, view, server) {
    return this.to('view/package/' + _package + '/' + view, server);
};


url.prototype.to = function(uri, server) {

    if(server == true) return this.base + '/' + uri;

    return '/' + uri;
};