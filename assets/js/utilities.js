
export class Util {
    static intParser(value = "") {
        value = value.toString().split("").reverse();
        
        var _values = [];
        for (let index = value.length - 1; index >= 0; index--) {
            _values.push(value[index]);
            
            if (index != 0) {
                if (index % 3 == 0) {
                    _values.push(",");
                }
            }
        }

        return _values.join("");

    }
}