export const helperFunc = {
    recursive: (canGetChildrenNotPrefix = false, data, newData = [], prefix = "", isChildren = false) => {
        if(typeof data !=="object") {
            return [];
        }
        data.forEach((item) => {
            item.prefix = null;
            if(isChildren) {
                item.prefix = prefix;
            }
            newData.push(item);
            if(item.children && item.children.length)
            {
                if(!canGetChildrenNotPrefix) {
                    helperFunc.recursive(canGetChildrenNotPrefix,item.children, newData, prefix, true);
                }else {
                  helperFunc.recursive(canGetChildrenNotPrefix, item.children, newData, prefix + "---", true);
                }
            }
        })
        return newData;
    },
    recursiveGetList: (data, newData = []) => {
        if(typeof data !=="object") {
            return [];
        }
        data.forEach((item) => {
            if(item.status == 1) {
                newData.push(item);
            }
            if(item.children && item.children.length)
            {
                helperFunc.recursiveGetList(item.children, newData);
            }
        })
        return newData;
    },
    shortString: (str, length=25) => {
        if(typeof str !== "string") {
            return str;
        }
        if(str.length < length) {
            return str;
        }
        return str.slice(0, length) + '...';
    },
    groupBy:(data, key, order) => {
        if(!data.length) {
            return [];
        }
        data.forEach((item, key) => {
                item.stt = key;
                return item;
              })
        let dataGroup = data.reduce(function(rv, x) {
          (rv[x[key]] = rv[x[key]] || []).push(x);
          return rv;
        }, {});
        // sắp xếp theo stt
        if(order == true) {
            let stt = 0;
            for( let key in dataGroup ) {
                dataGroup[key].forEach((item) => {
                    item.stt = stt;
                    stt ++ ;
                    return item;
                })
            }
        }
        return dataGroup;
      },

    formatNumber: (numbers = 0) => {
        if (typeof (numbers) instanceof Array) {
            for (let [i, money] in numbers.entries()) {
                money = parseInt(money)
                numbers[i] = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(money)
            }
            return numbers
        }
        return new Intl.NumberFormat().format(numbers);
    },
}
