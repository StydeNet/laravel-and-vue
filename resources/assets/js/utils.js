module.exports = {
    findById: function (items, id) {
        for (var i in items) {
            if (items[i].id == id) {
                return items[i];
            }
        }

        return null;
    },
    assign: function (original, newData) {
        for(var key in newData) {
            original[key] = newData[key];
        }
    }
}