App = {
    web3Provider: null,
    contracts: {},
    account: '0x0',
    loading: false,
    tokenPrice: 100000000000000000,
    tokensSold: 0,
    tokensAvailable: 2000000000000,

    init: function () {
        console.log("App initialized...")
        return App.initWeb3();
    },


    initWeb3: async function () {
        if (window.ethereum) {
            App.web3Provider = window.ethereum;
            try {
                // Request account access
                await window.ethereum.enable();
            } catch (error) {
                // User denied account access...
                console.error("User denied account access")
            }
        }
        // Legacy dapp browsers...
        else if (window.web3) {
            App.web3Provider = window.web3.currentProvider;
        }
        // If no injected web3 instance is detected, fall back to Ganache
        else {
            App.web3Provider = new Web3.providers.HttpProvider('http://localhost:7545');
        }
        web3 = new Web3(App.web3Provider);
        window.ethereum.on('chainChanged', (chainId) => {
            // Handle the new chain.
            // Correctly handling chain changes can be complicated.
            // We recommend reloading the page unless you have a very good reason not to.
            window.location.reload()

        });
        window.ethereum.on('accountsChanged', (accounts) => {
            // Handle the new accounts, or lack thereof.
            // "accounts" will always be an array, but it can be empty.
            window.location.reload()
        });
        return App.initContracts();
    },

    initContracts: function () {
        $.getJSON("Staking.json", function (staking) {
            App.contracts.Staking = TruffleContract(staking);
            App.contracts.Staking.setProvider(App.web3Provider);
            App.contracts.Staking.deployed().then(function (staking) {
                console.log("Dapp Token Sale Address:", staking.address);
            });
        }).done(function () {
            $.getJSON("GainToken.json", function (gainToken) {
                App.contracts.GainToken = TruffleContract(gainToken);
                App.contracts.GainToken.setProvider(App.web3Provider);
                App.contracts.GainToken.deployed().then(function (gainToken) {
                    console.log("Dapp Token Address:", gainToken.address);
                });

                App.listenForEvents();
                return App.render();
            });
        })
    },

    // Listen for events emitted from the contract
    listenForEvents: function () {
        App.contracts.Staking.deployed().then(function (instance) {
            instance.Transfer({}, {
                fromBlock: 'latest',
                toBlock: 'latest',
            }).watch(function (error, event) {
                console.log("event triggered", event);
                App.render();
            })
        })
    },

    render: async function () {
        if (App.loading) {
            return;
        }
        App.loading = true;

        var loader = $('#loader');
        var content = $('#content');

        loader.show();
        content.hide();

        // loader.hide();
        // content.show();

        // Load account data
        web3.eth.getCoinbase(function (err, account) {
            if (err === null) {
                App.account = account;
                $('#accountAddress').html("Your Account: " + account);
            }
        })

        // Load token sale contract
        App.contracts.Staking.deployed().then(function (instance) {
            stakingInstance = instance;
            // return stakingInstance.tokenPrice();
            return stakingInstance.APY();
        }).then(function (apy) {
            var apy_function = apy.toNumber() / 10 ** 2;
            var appFuntion = apy_function + ' %';
            // var appFuntion = '20 %';

            $('.apy').html(appFuntion);
            return stakingInstance.stakes(App.account);
            // return stakingInstance.stakes('0x30724f1dc6bf8d8dbE3c5A358A942211FCA3b010');
            // return stakingInstance.stakes('0x618E7cf8eC21A5D9d5357d7149e9b350340Ee3B8');
        }).then(function (start) {
            // console.log('1');
            // console.log(start);
            // console.log(start[1].toNumber());
            var start_time = start[1].toNumber();

            if (start_time == 0) {
                $('.start_time').html(start_time);
                $('.finish_time').html(start_time);
            } else {

                // Months array
                var months_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                ///=============Start Date/time========================================
                var s_date = new Date(start_time * 1000);
                // Year
                var s_year = s_date.getFullYear();

                // Month
                var s_month = months_arr[s_date.getMonth()];
                // Day
                var s_day = s_date.getDate();
                // Hours
                var s_hours = ((s_date.getHours() % 12 || 12) < 10 ? '0' : '') + (s_date.getHours() % 12 || 12);
                // Minutes
                var s_minutes = (s_date.getMinutes() < 10 ? '0' : '') + s_date.getMinutes();
                var s_meridiem = (s_date.getHours() >= 12) ? 'PM' : 'AM';
                var startDateTime = s_day + ' ' + s_month + ',' + s_year + ' ' + s_hours + ':' + s_minutes + ' ' + s_meridiem;

                $('.start_time').html(startDateTime);

                ///=============Finish Date/time========================================
                var f_timeStamp = new Date(start_time * 1000);
                f_timeStamp.setDate(f_timeStamp.getDate() + 7);
                // Year
                var f_year = f_timeStamp.getFullYear();

                // Month
                var f_month = months_arr[f_timeStamp.getMonth()];
                // Day
                var f_day = f_timeStamp.getDate();
                // Hours
                var f_hours = ((f_timeStamp.getHours() % 12 || 12) < 10 ? '0' : '') + (f_timeStamp.getHours() % 12 || 12);
                // Minutes
                var f_minutes = (f_timeStamp.getMinutes() < 10 ? '0' : '') + f_timeStamp.getMinutes();
                var f_meridiem = (f_timeStamp.getHours() >= 12) ? 'PM' : 'AM';
                var finishDateTime = f_day + ' ' + f_month + ',' + f_year + ' ' + f_hours + ':' + f_minutes + ' ' + f_meridiem;

                $('.finish_time').html(finishDateTime);
            }

            return stakingInstance.balanceOf(App.account);
        }).then(function (balanceOf) {
            // console.log(balanceOf); 

            var balance = balanceOf.toNumber() / 10 ** 5 + ' GAIN';

            $('.your_stake').html(balance);

            return stakingInstance.totalTokenStaked();
        }).then(function (tokenStaked) {
            // App.loading = false;
            //     loader.hide();
            //     content.show();
            var totalToken = 20000000;
            var totalStaked = tokenStaked.toNumber() / 10 ** 5;
            var total_percentage = totalStaked / totalToken;
            // console.log(totalStaked);
            // console.log(totalToken);
            // console.log(total_percentage);

            var subtotal = parseFloat(total_percentage) * 100;
            var subtotal = subtotal.toFixed(10) + ' %'; //two decimal places

            $('.totalStaked').html(totalStaked);
            $('.totalToken').html(totalToken);
            $('.total_percentage').html(subtotal);

        });
    },

    buyTokens: function () {
        $('#content').hide();
        $('#loader').show();
        var numberOfTokens = $('#numberOfstakeTokens').val();
        console.log("dsfsadgasdfgasdfasdf", Number(numberOfTokens * App.tokenPrice));
        App.contracts.Staking.deployed().then(function (instance) {
            return instance.createStake(numberOfTokens, {
                from: App.account,
                value: Number(numberOfTokens * App.tokenPrice),
                gas: 500000 // Gas limit
            });


        }).then(function (result) {
            console.log("Tokens staked...")

            // alert('Reloading Page');
            window.location.reload()
            $('form').trigger('reset') // reset number of tokens in form
            // Wait for Sell event
        });


    },

    unstakeTokens: function () {
        $('#content').hide();
        $('#loader').show();
        var numberOfTokens = $('#numberOfunstakeTokens').val();
        App.contracts.Staking.deployed().then(function (instance) {
            return instance.removeStake(numberOfTokens, {
                from: App.account,
                gas: 500000 // Gas limit
            });
        }).then(function (result) {
            console.log("Tokens unstaked...")
            // $(".start_time").text("13 Jun, 2021 1:30 AM");
            // alert('Reloading Page');
            window.location.reload()

            $('form').trigger('reset') // reset number of tokens in form
            // Wait for Sell event
        });
    },

    getBalance: function () {
        // $('#content').hide();
        // $('#loader').show();
        var address = $('#address').val();
        App.contracts.Staking.deployed().then(function (instance) {
            return instance.balanceOf(address);
        }).then(function (result) {
            return (result.toNumber() / 10 ** 5)
        });
    },

    totalStaked: function () {
        App.contracts.Staking.deployed().then(function (instance) {
            return instance.totalTokenStaked();
        }).then(function (total) {
            return (total.toNumber() / 10 ** 5)
        })
    },

    APY: function () {

        App.contracts.Staking.deployed().then(function (instance) {
            return instance.APY();
        }).then(function (apy) {
            console.log("APY function");
            var a = apy.toNumber();
            console.log(a);

            var apy_function = apy.toNumber() / 10 ** 2;
            var appFuntion = apy_function + ' %';
            $('.apy').html(appFuntion);
            // return (apy.Number() / 10 ** 2)
            return (apy.toNumber() / 10 ** 2)
        })
    },

    startTime: function () {
        console.log("startTime")
        App.contracts.Staking.deployed().then(function (instance) {
            return instance.stakes(App.account);
        }).then(function (apy) {
            return (apy.stakeTime)
        })
    },

}





$(function () {
    $(window).load(function () {
        App.init();


        // App.getBalance();
        // App.totalStaked();
        // App.APY();
        // App.startTime();

    })


});