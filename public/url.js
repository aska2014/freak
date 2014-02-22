function url (_base) {
    this.base = _base.replace(/\/+$/,'');
}

url.prototype.serverConfiguration = function(uri) {
    return this.to('configuration/' + uri, true);
};

url.prototype.serverPage = function(_page) {
    return this.to('pages/' + _page + '.html', true);
};

url.prototype.serverElement = function(_element, uri) {
    uri = typeof uri !== 'undefined' ? uri : '';

    return this.to('element/' + _element + '/' + uri, true);
};

url.prototype.serverPackage = function(_package, uri) {
    uri = typeof uri !== 'undefined' ? uri : '';

    return this.to('package/' + _package + '/' + uri, true);
};

url.prototype.serverElementView = function(_element, view) {

    return this.to('view/element/' + _element + '/' + view, true);
};

url.prototype.serverPackageView = function(_element, view) {

    return this.to('view/element/' + _element + '/' + view, true);
};

url.prototype.elementView = function(_element, view) {

    return this.to('view/element/' + _element + '/' + view);
};

url.prototype.packageView = function(_package, view) {
    return this.to('view/package/' + _package + '/' + view);
};


url.prototype.to = function(uri, server) {
    if(server == true) {
        return this.base + '/' + uri.replace(/\/+$/, '');
    }

    return '/' + uri;
};