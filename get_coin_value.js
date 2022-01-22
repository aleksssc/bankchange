const CoinMarketCap = require('coinmarketcap-api')
const { exit } = require('process')

const apiKey = 'cf7bea7b-0f57-4970-b6e0-04df2f09e2e4'
const client = new CoinMarketCap(apiKey)

var btc_name = ""
var btc_price = ""

var eth_name = ""
var eth_price = ""

var bnb_name = ""
var bnb_price = ""

function extractData(res) {
    btc_symbol = res.data['BTC'].symbol
    btc_price = res.data['BTC'].quote.EUR.price

    eth_symbol = res.data['ETH'].symbol
    eth_price = res.data['ETH'].quote.EUR.price

    bnb_symbol = res.data['BNB'].symbol
    bnb_price = res.data['BNB'].quote.EUR.price

    var mysql = require('mysql');

    var con = mysql.createConnection({
        host: "localhost",
        user: "root",
        password: "",
        database: "bankchange"
    });

    con.connect(function (err) {
        if (err) throw err;
        var sql = "UPDATE `crypto_currencies` SET `price_crypto`='" + btc_price + "' WHERE `symbol_crypto`='" + btc_symbol + "'"
        con.query(sql, function (err, result) {
            if (err) throw err;
            console.log(result.affectedRows + " record(s) updated");
        });
        var sql = "UPDATE `crypto_currencies` SET `price_crypto`='" + eth_price + "' WHERE `symbol_crypto`='" + eth_symbol + "'"
        con.query(sql, function (err, result) {
            if (err) throw err;
            console.log(result.affectedRows + " record(s) updated");
        });
        var sql = "UPDATE `crypto_currencies` SET `price_crypto`='" + bnb_price + "' WHERE `symbol_crypto`='" + bnb_symbol + "'"
        con.query(sql, function (err, result) {
            if (err) throw err;
            console.log(result.affectedRows + " record(s) updated");
        });
    });
}


setInterval(function () {
    client.getQuotes({ symbol: 'BTC,ETH,BNB', convert: 'EUR' })
        .then(data => extractData(data))
}, 1800000);



