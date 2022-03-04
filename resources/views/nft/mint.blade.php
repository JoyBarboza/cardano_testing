@extends('layouts.nft')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('nft.mint_item')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE TITLE-->
@endsection
@push('css')
<style>
    .mint_form #left-code {
        width: 300px;
        font-size: 16px;
    }
    .mint_form {
        display: inline-block;
        width: 100%;
        padding: 25px;
        background: #fff;
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 50%);
    }
    .mint_form .col-md-12 {
        display: flex;
        align-items: center;
        margin: 5px auto;
    }
    .mint_form input, .mint_form textarea {
        width: calc(100% - 350px);
        margin-left: auto;
        border: 1px solid #ddd;
    }
    
    .mint_form input {
        height: 38px;
    }
    .mint_form textarea {
        height: 100px;
    }
    .mint_submit {
        margin: 15px auto;
        display: block;
        width: 250px !important;
        font-size: 17px !important;
    }
</style>
@endpush
@section('contents')
    <div class="row">


        <div class="col-md-12 col-sm-12">
            <h3>{{trans('nft.mint_an_item')}}</h3><hr>

            @include('flash::message')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- <form> -->
                <!-- {{ csrf_field() }} -->
                <div class="card-widget white">
                    <label>Note : 1 CSM = {{$bnb_csm->bnb}} BNB</label>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card-widget white mint_form">
                                <div class="row margin-top-20">
                                    <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_name')}}</h6>

                                        <input type='text' name="name" id="name" required>
                                        <span style="color: red" id="r_name"></span>
                                    </div>  

                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_img')}}</h6>

                                         <img width="100" id="img_add" name="nft_img">

                                        <!--<input type='file' name="nft_img" id="imgadd" class="upload" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_img')}}"/>-->
                                        
                                         <input type="file" name="nft_img" id="photo" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_img')}}">
                                         <span style="color: red" id="r_nft_img"></span>
                                         <!--<button type="button" id="hash" name="hash" onclick="download()">Download</button>-->
                                    </div>
                                    
                                    <input type='hidden' name="ipfs_url" id="ipfs_url" value="" placeholder="IPFS URL" />

                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_descripition')}}</h6>
                                        <textarea name="descripition" id="descripition" class="upload" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_descripition')}}"></textarea>
                                        <span style="color: red" id="r_descripition"></span>
                                    </div>    

                                    <input type="hidden" name="bnb_price" value="{{$bnb_csm->bnb}}" class="bnb_price" id="bnb_price">

                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">{{trans('nft.mint_price')}} (CSM)</h6>
                                        <input type='number' name="price" id="csm_price" required data-parsley-required data-parsley-required-message="{{trans('nft.mint_price')}}" min="1" />
                                        <span style="color: red" id="r_price"></span>
                                    </div>   


                                     <div class="col-md-12">
                                        <h6 style="display: inline-block;" id="left-code">Royality Price (%)</h6>
                                        <input type='number' name="royalty" id="royalty" required data-parsley-required data-parsley-required-message="Enter Royality Price" min="1" />
                                        <span style="color: red" id="r_royalty"></span>
                                    </div>                             

                                    <!-- <input type="text" name="tokenId" id="tokenId" value="5" placeholder="token Id"> -->
                                    <!-- <input type="text" name="transaction_id" id="transaction_id" value="gfhgfgh" placeholder="transaction id"> -->
                                    <input type="hidden" name="nft_type" id="nft_type" value="1" placeholder="nft type">
                                    
                                </div>
                                 <div class="col-md-12">
                                    <!-- <button type="submit" class="btn mint_submit btn-block btn-primary" onclick="upload()" >{{trans('nft.mint')}}</button> -->
                                    <button type="submit" class="btn mint_submit btn-block btn-primary" onclick="mintNft();">{{trans('nft.mint')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
        </div>      
    </div>
@endsection
@push('css')
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@push('js')

 <div id="checkMetamask" class="modal create_wallet_modal fade" tabindex="-1">
        <!-- <form method="POST" action="{{ route('presale.account') }}" enctype="multipart/form-data" data-parsley-validate> -->
            <!-- {{ csrf_field() }} -->
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color: #100f0f;font-size: x-large;align-items: center;">How to Install and Use Metamask</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <p class="m-4" style="color: black;"> <b>Step 1:</b> Go to Chrome Web Store Extensions Section.</p>
                        <p class="m-4" style="color: black;"> <b>Step 2:</b> Search MetaMask.</p>
                        <p class="m-4" style="color: black;"> <b>Step 3:</b> Check the number of downloads to make sure that the legitimate MetaMask is being installed, as hackers might try to make clones of it.</p>
                        <p class="m-4" style="color: black;"> <b>Step 4:</b> Click the Add to Chrome button.</p>
                        <p class="m-4" style="color: black;"> <b>Step 5:</b> Once installation is complete this page will be displayed. Click on the Get Started button.</p>
                        <p class="m-4" style="color: black;"> <b>Step 6:</b> This is the first time creating a wallet, so click the Create a Wallet button. If there is already a wallet then import the already created using the Import Wallet button.</p>
                        <p class="m-4" style="color: black;"> <b>Step 7:</b> Click I Agree button to allow data to be collected to help improve MetaMask or else click the No Thanks button. The wallet can still be created even if the user will click on the No Thanks button.</p>
                        <p class="m-4" style="color: black;"> <b>Step 8:</b> Create a password for your wallet. This password is to be entered every time the browser is launched and wants to use MetaMask. A new password needs to be created if chrome is uninstalled or if there is a switching of browsers. In that case, go through the Import Wallet button. This is because MetaMask stores the keys in the browser. Agree to Terms of Use.</p>
                        <p class="m-4" style="color: black;"> <b>Step 9:</b> Click on the dark area which says Click here to reveal secret words to get your secret phrase. </p>
                        <p class="m-4" style="color: black;"> <b>Step 10:</b> This is the most important step. Back up your secret phrase properly. Do not store your secret phrase on your computer. Please read everything on this screen until you understand it completely before proceeding. The secret phrase is the only way to access your wallet if you forget your password. Once done click the Next button. </p>
                        <p class="m-4" style="color: black;"> <b>Step 11:</b> Click the buttons respective to the order of the words in your seed phrase. In other words, type the seed phrase using the button on the screen. If done correctly the Confirm button should turn blue.</p>
                        <p class="m-4" style="color: black;"> <b>Step 12:</b> Click the Confirm button. Please follow the tips mentioned.</p>
                        <p class="m-4" style="color: black;"> <b>Step 13:</b> One can see the balance and copy the address of the account by clicking on the Account 1 area.</p>
                        <p class="m-4" style="color: black;"> <b>Step 14:</b> One can access MetaMask in the browser by clicking the Foxface icon on the top right. If the Foxface icon is not visible, then click on the puzzle piece icon right next to it.</p>

                    </div>

                    <div class="modal-footer">
                        <!-- <button type="submit" class="btn mint_submit btn-block btn-primary">{{trans('nft.submit')}}</button> -->

                        <!-- <button class="btn btn-info submitButton">Submit</button> -->

                        <button type="button" class="btn btn-secondary cancle_btn" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        <!-- </form> -->
    </div>

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.pie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.stack.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.crosshair.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.axislabels.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/flot/jquery.flot.time.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="{{ asset('assets/pages/scripts/charts-flotcharts.js') }}?v={{time()}}" type="text/javascript"></script> 
    <!-- END PAGE LEVEL SCRIPTS -->
    
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js"></script>

<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
<script src="https://bundle.run/buffer@6.0.3"></script>

<script type="text/javascript">

    /* eslint-disable */
    /* eslint-disable */
    (function webpackUniversalModuleDefinition(root, factory) {
        if (typeof exports === 'object' && typeof module === 'object')
            module.exports = factory();
        else if (typeof define === 'function' && define.amd)
            define("IPFS", [], factory);
        else if (typeof exports === 'object')
            exports["IPFS"] = factory();
        else
            root["IPFS"] = factory();
    })(this, function () {
        return /******/ (function (modules) { // webpackBootstrap
            /******/ // The module cache
            /******/
            var installedModules = {};
            /******/
            /******/ // The require function
            /******/
            function __webpack_require__(moduleId) {
                /******/
                /******/ // Check if module is in cache
                /******/
                if (installedModules[moduleId])
                    /******/
                    return installedModules[moduleId].exports;
                /******/
                /******/ // Create a new module (and put it into the cache)
                /******/
                var module = installedModules[moduleId] = {
                    /******/
                    i: moduleId,
                    /******/
                    l: false,
                    /******/
                    exports: {}
                    /******/
                };
                /******/
                /******/ // Execute the module function
                /******/
                modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
                /******/
                /******/ // Flag the module as loaded
                /******/
                module.l = true;
                /******/
                /******/ // Return the exports of the module
                /******/
                return module.exports;
                /******/
            }
            /******/
            /******/
            /******/ // expose the modules object (__webpack_modules__)
            /******/
            __webpack_require__.m = modules;
            /******/
            /******/ // expose the module cache
            /******/
            __webpack_require__.c = installedModules;
            /******/
            /******/ // identity function for calling harmory imports with the correct context
            /******/
            __webpack_require__.i = function (value) {
                return value;
            };
            /******/
            /******/ // define getter function for harmory exports
            /******/
            __webpack_require__.d = function (exports, name, getter) {
                /******/
                Object.defineProperty(exports, name, {
                    /******/
                    configurable: false,
                    /******/
                    enumerable: true,
                    /******/
                    get: getter
                    /******/
                });
                /******/
            };
            /******/
            /******/ // Object.prototype.hasOwnProperty.call
            /******/
            __webpack_require__.o = function (object, property) {
                return Object.prototype.hasOwnProperty.call(object, property);
            };
            /******/
            /******/ // __webpack_public_path__
            /******/
            __webpack_require__.p = "";
            /******/
            /******/ // Load entry module and return exports
            /******/
            return __webpack_require__(__webpack_require__.s = 1);
            /******/
        })
        /************************************************************************/
        /******/
        ([
            /* 0 */
            /***/
            function (module, exports) {

                "use strict";
                "use strict";

                var XMLHttpRequest = window.XMLHttpRequest; // eslint-disable-line

                module.exports = XMLHttpRequest;

                /***/
            },
            /* 1 */
            /***/
            function (module, exports, __webpack_require__) {

                "use strict";
                'use strict';

                var XMLHttpRequest = __webpack_require__(0);

                module.exports = IPFS;

                /**
                 * The constructor object
                 * @param {Object} `provider` the provider object
                 * @return {Object} `ipfs` returns an IPFS instance
                 * @throws if the `new` flag is not used
                 */
                function IPFS(provider) {
                    if (!(this instanceof IPFS)) {
                        throw new Error('[ipfs-mini] IPFS instance must be instantiated with "new" flag (e.g. var ipfs = new IPFS("http://localhost:8545");).');
                    }

                    var self = this;
                    self.setProvider(provider || {});
                }

                /**
                 * Sets the provider of the IPFS instance
                 * @param {Object} `provider` the provider object
                 * @throws if the provider object is not an object
                 */
                IPFS.prototype.setProvider = function setProvider(provider) {
                    if (typeof provider !== 'object') {
                        throw new Error('[ifpsjs] provider must be type Object, got \'' + typeof provider + '\'.');
                    }
                    var self = this;
                    var data = self.provider = Object.assign({
                        host: '127.0.0.1',
                        pinning: true,
                        port: '5001',
                        protocol: 'http',
                        base: '/api/v0'
                    }, provider || {});
                    self.requestBase = String(data.protocol + '://' + data.host + ':' + data.port + data.base);
                };

                /**
                 * Sends an async data packet to an IPFS node
                 * @param {Object} `opts` the options object
                 * @param {Function} `cb` the provider callback
                 * @callback returns an error if any, or the data from IPFS
                 */
                IPFS.prototype.sendAsync = function sendAsync(opts, cb) {
                    var self = this;
                    var request = new XMLHttpRequest(); // eslint-disable-line
                    var options = opts || {};
                    var callback = cb || function emptyCallback() {};

                    request.onreadystatechange = function () {
                        if (request.readyState === 4 && request.timeout !== 1) {
                            if (request.status !== 200) {
                                callback(new Error('[ipfs-mini] status ' + request.status + ': ' + request.responseText), null);
                            } else {
                                try {
                                    callback(null, options.jsonParse ? JSON.parse(request.responseText) : request.responseText);
                                } catch (jsonError) {
                                    callback(new Error('[ipfs-mini] while parsing data: \'' + String(request.responseText) + '\', error: ' + String(jsonError) + ' with provider: \'' + self.requestBase + '\'', null));
                                }
                            }
                        }
                    };

                    var pinningURI = self.provider.pinning && opts.uri === '/add' ? '?pin=true' : '';

                    if (options.payload) {
                        request.open('POST', '' + self.requestBase + opts.uri + pinningURI);
                    } else {
                        request.open('GET', '' + self.requestBase + opts.uri + pinningURI);
                    }

                    if (options.accept) {
                        request.setRequestHeader('accept', options.accept);
                    }

                    if (options.payload && options.boundary) {
                        request.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + options.boundary);
                        request.send(options.payload);
                    } else {
                        request.send();
                    }
                };

                /**
                 * creates a boundary that isn't part of the payload
                 */
                function createBoundary(data) {
                    while (true) {
                        var boundary = '----IPFSMini' + Math.random() * 100000 + '.' + Math.random() * 100000;
                        if (data.indexOf(boundary) === -1) {
                            return boundary;
                        }
                    }
                }

                /**
                 * Add an string or buffer to IPFS
                 * @param {String|Buffer} `input` a single string or buffer
                 * @param {Function} `callback` a callback, with (error, ipfsHash String)
                 * @callback {String} `ipfsHash` returns an IPFS hash string
                 */
                IPFS.prototype.add = function addData(input, callback) {
                    var data = typeof input === 'object' && input.isBuffer ? input.toString('binary') : input;
                    var boundary = createBoundary(data);
                    var payload = '--' + boundary + '\r\nContent-Disposition: form-data; name="path"\r\nContent-Type: application/octet-stream\r\n\r\n' + data + '\r\n--' + boundary + '--';

                    var addCallback = function addCallback(err, result) {
                        return callback(err, !err ? result.Hash : null);
                    };
                    this.sendAsync({
                        jsonParse: true,
                        accept: 'application/json',
                        uri: '/add',
                        payload: payload,
                        boundary: boundary
                    }, addCallback);
                };

                /**
                 * Add an JSON object to IPFS
                 * @param {Object} `jsonData` a single JSON object
                 * @param {Function} `callback` a callback, with (error, ipfsHash String)
                 * @callback {String} `ipfsHash` returns an IPFS hash string
                 */
                IPFS.prototype.addJSON = function addJson(jsonData, callback) {
                    var self = this;
                    self.add(JSON.stringify(jsonData), callback);
                };

                /**
                 * Get an object stat `/object/stat` for an IPFS hash
                 * @param {String} `ipfsHash` a single IPFS hash String
                 * @param {Function} `callback` a callback, with (error, stats Object)
                 * @callback {Object} `stats` returns the stats object for that IPFS hash
                 */
                IPFS.prototype.stat = function cat(ipfsHash, callback) {
                    var self = this;
                    self.sendAsync({
                        jsonParse: true,
                        uri: '/object/stat/' + ipfsHash
                    }, callback);
                };

                /**
                 * Get the data from an IPFS hash
                 * @param {String} `ipfsHash` a single IPFS hash String
                 * @param {Function} `callback` a callback, with (error, stats Object)
                 * @callback {String} `data` returns the output data
                 */
                IPFS.prototype.cat = function cat(ipfsHash, callback) {
                    var self = this;
                    self.sendAsync({
                        uri: '/cat/' + ipfsHash
                    }, callback);
                };

                /**
                 * Get the data from an IPFS hash that is a JSON object
                 * @param {String} `ipfsHash` a single IPFS hash String
                 * @param {Function} `callback` a callback, with (error, json Object)
                 * @callback {Object} `data` returns the output data JSON object
                 */
                IPFS.prototype.catJSON = function cat(ipfsHash, callback) {
                    var self = this;
                    self.cat(ipfsHash, function (jsonError, jsonResult) {
                        // eslint-disable-line
                        if (jsonError) {
                            return callback(jsonError, null);
                        }

                        try {
                            callback(null, JSON.parse(jsonResult));
                        } catch (jsonParseError) {
                            callback(jsonParseError, null);
                        }
                    });
                };

                /***/
            }
            /******/
        ])
    });;
    //# sourceMappingURL=ipfs-mini.js.map

    function base64ArrayBuffer(arrayBuffer) {
        let base64 = '';
        const encodings = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

        const bytes = new Uint8Array(arrayBuffer);
        const byteLength = bytes.byteLength;
        const byteRemainder = byteLength % 3;
        const mainLength = byteLength - byteRemainder;

        let a;
        let b;
        let c;
        let d;
        let chunk;

        // Main loop deals with bytes in chunks of 3
        for (let i = 0; i < mainLength; i += 3) {
            // Combine the three bytes into a single integer
            chunk = (bytes[i] << 16) | (bytes[i + 1] << 8) | bytes[i + 2];

            // Use bitmasks to extract 6-bit segments from the triplet
            a = (chunk & 16515072) >> 18; // 16515072 = (2^6 - 1) << 18
            b = (chunk & 258048) >> 12; // 258048   = (2^6 - 1) << 12
            c = (chunk & 4032) >> 6; // 4032     = (2^6 - 1) << 6
            d = chunk & 63; // 63       = 2^6 - 1

            // Convert the raw binary segments to the appropriate ASCII encoding
            base64 += encodings[a] + encodings[b] + encodings[c] + encodings[d];
        }

        // Deal with the remaining bytes and padding
        if (byteRemainder === 1) {
            chunk = bytes[mainLength];

            a = (chunk & 252) >> 2; // 252 = (2^6 - 1) << 2

            // Set the 4 least significant bits to zero
            b = (chunk & 3) << 4; // 3   = 2^2 - 1

            base64 += `${encodings[a]}${encodings[b]}==`;
        } else if (byteRemainder === 2) {
            chunk = (bytes[mainLength] << 8) | bytes[mainLength + 1];

            a = (chunk & 64512) >> 10; // 64512 = (2^6 - 1) << 10
            b = (chunk & 1008) >> 4; // 1008  = (2^6 - 1) << 4

            // Set the 2 least significant bits to zero
            c = (chunk & 15) << 2; // 15    = 2^4 - 1

            base64 += `${encodings[a]}${encodings[b]}${encodings[c]}=`;
        }

        return base64;
    }

    function initialize() {
        return new IPFS({
            host: 'ipfs.infura.io',
            protocol: 'https'
        });
    }

     
    const ipfs = initialize();
    var base64buf;

     async function loadWeb3() {
      // if (window.ethereum) {
      //    window.web3 = new Web3(window.ethereum);
      //    window.ethereum.enable();

      //    //  await window.web3.eth.getTransactionReceipt('0x59b120e1d6de0c9a987a5e5d60ade97778be183d47cbf69cabbe60af3ed4e209').then(function(data){
      //    //     let transaction = data;
      //    //     let logs = data.logs;
      //    //     console.log(logs);
      //    //     console.log(web3.utils.hexToNumber(logs[0].topics[3]));
      //    // });
      // }

       if (window.ethereum) {
            window.web3 = new Web3(window.ethereum);
            window.ethereum.enable();
        }else {

            // alert('You need metamask extenstion to deposite ADA and buy CZM.');

            // var url = 'https://testnets.cardano.org/en/testnets/cardano/get-started/wallet/';
            // window.open(url, '_blank');
            $("#checkMetamask").modal('show');
        }
   }

   async function loadContract() {
      // return await new window.web3.eth.Contract([ { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "approved", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "operator", "type": "address" }, { "indexed": false, "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "ApprovalForAll", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "approve", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "add", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "approvethis", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_bidAmount", "type": "uint256" } ], "name": "bid", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "indexed": false, "internalType": "address", "name": "_buyer", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BoughtNFT", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "BuyBidNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_owner", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BuyNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "mintAuctionLength", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "MintFixedNFT", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "nftSold", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" } ], "name": "resellAuctionNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" } ], "name": "resellNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" }, { "internalType": "bytes", "name": "_data", "type": "bytes" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "operator", "type": "address" }, { "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "setApprovalForAll", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "transferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "_tokenApprovals", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "getApproved", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "HighestBiderAddress", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "imageData", "outputs": [ { "internalType": "string", "name": "Artwork_name", "type": "string" }, { "internalType": "string", "name": "Artwork_type", "type": "string" }, { "internalType": "address", "name": "Author", "type": "address" }, { "internalType": "string", "name": "Artwork_description", "type": "string" }, { "internalType": "string", "name": "Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "Royalty", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "images", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "operator", "type": "address" } ], "name": "isApprovedForAll", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "ownerOf", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "bytes4", "name": "interfaceId", "type": "bytes4" } ], "name": "supportsInterface", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenOfOwnerByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "tokenURI", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ], '0xb079120b0eb13f204752887a50f7327d51c15d5f');

      return await new window.web3.eth.Contract([ { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "approved", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Approval", "type": "event" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "owner", "type": "address" }, { "indexed": true, "internalType": "address", "name": "operator", "type": "address" }, { "indexed": false, "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "ApprovalForAll", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "approve", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "add", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "approvethis", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_bidAmount", "type": "uint256" } ], "name": "bid", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": false, "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "indexed": false, "internalType": "address", "name": "_buyer", "type": "address" }, { "indexed": false, "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BoughtNFT", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "BuyBidNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "_owner", "type": "address" }, { "internalType": "uint256", "name": "_tokenId", "type": "uint256" }, { "internalType": "uint256", "name": "_price", "type": "uint256" } ], "name": "BuyNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "mintAuctionLength", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "string", "name": "_Artwork_name", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "string", "name": "_Artwork_description", "type": "string" }, { "internalType": "string", "name": "_Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "_Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "_Royalty", "type": "uint256" } ], "name": "MintFixedNFT", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_tokenId", "type": "uint256" } ], "name": "nftSold", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "uint256", "name": "_Auction_Length", "type": "uint256" } ], "name": "resellAuctionNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "_token", "type": "uint256" }, { "internalType": "uint256", "name": "_newPrice", "type": "uint256" }, { "internalType": "string", "name": "_newName", "type": "string" }, { "internalType": "string", "name": "_Artwork_type", "type": "string" } ], "name": "resellNFT", "outputs": [ { "internalType": "string", "name": "", "type": "string" }, { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" }, { "internalType": "bytes", "name": "_data", "type": "bytes" } ], "name": "safeTransferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "operator", "type": "address" }, { "internalType": "bool", "name": "approved", "type": "bool" } ], "name": "setApprovalForAll", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "address", "name": "from", "type": "address" }, { "indexed": true, "internalType": "address", "name": "to", "type": "address" }, { "indexed": true, "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "Transfer", "type": "event" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "transferFrom", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "_tokenApprovals", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" } ], "name": "balanceOf", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "getApproved", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "HighestBiderAddress", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "imageData", "outputs": [ { "internalType": "string", "name": "Artwork_name", "type": "string" }, { "internalType": "string", "name": "Artwork_type", "type": "string" }, { "internalType": "address", "name": "Author", "type": "address" }, { "internalType": "string", "name": "Artwork_description", "type": "string" }, { "internalType": "string", "name": "Artwork_url_image", "type": "string" }, { "internalType": "uint256", "name": "Artwork_price", "type": "uint256" }, { "internalType": "uint256", "name": "Auction_Length", "type": "uint256" }, { "internalType": "uint256", "name": "Royalty", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "name": "images", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "address", "name": "operator", "type": "address" } ], "name": "isApprovedForAll", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "name", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "ownerOf", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "bytes4", "name": "interfaceId", "type": "bytes4" } ], "name": "supportsInterface", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "symbol", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "owner", "type": "address" }, { "internalType": "uint256", "name": "index", "type": "uint256" } ], "name": "tokenOfOwnerByIndex", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "tokenId", "type": "uint256" } ], "name": "tokenURI", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "totalSupply", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" } ], '0xb1355baA92f0b01Fc1f968cb12c6D24c5457d801');
   }


   async function load() {
      await loadWeb3();
      window.contract = await loadContract();
      updateStatus('Ready!');
   }

   async function getCurrentAccount() {
      const accounts = await window.web3.eth.getAccounts();
      return accounts[0];r
  }
  
    async function mintNft() 
    {
        console.log('mintNft');

        if (ethereum && ethereum.isMetaMask) {
            console.log('Ethereum successfully detected!');
        } else {
            $("#checkMetamask").modal('show');
        }
       

        // if($('#name').val() == '')
        // {
        //     console.log('false');
        //     $('#r_name').html('Name is required');
        //     return false;
        // }else{
        //     $('#r_name').html();
        // }

        // if($('#price').val() == '')
        // {
        //     console.log('false');
        //     $('#r_price').html('Price is required');
        //     return false;
        // }else{
        //     $('#r_price').html();
        // }

        // if($('#royalty').val() == '')
        // {
        //     console.log('false');
        //     $('#r_royalty').html('Royalty is required');
        //     return false;
        // }else{
        //     $('#r_royalty').html();
        // }

        // if($('#descripition').val() == '')
        // {
        //     console.log('false');
        //     $('#r_descripition').html('Descripition is required');
        //     return false;
        // }else{
        //     $('#r_descripition').html();
        // }
         
        // console.log('true');

        const account = await getCurrentAccount();
        const receiverAddress = account;

        console.log(receiverAddress);

        const reader = new FileReader();

        reader.onloadend = function() {
            const photo = document.getElementById("photo");
            console.log(photo.files[0].name);

            // if(photo == '' || empty(photo))
            // {
            //     console.log('false');
            //     $('#r_nft_img').html('Image is required');
            //     return false;
            // }else{
            //     $('#r_nft_img').html();
            // }

            const fileType = photo.files[0].type;



            const prefix = `data:${fileType};base64,`;
            const buf = buffer.Buffer(reader.result);
            base64buf = prefix + base64ArrayBuffer(buf);
            // Convert data into buffer
            ipfs.add(base64buf, (err, result) => { // Upload buffer to IPFS
                if (err) {
                    console.error(err)
                    return
                }

                let url = `https://ipfs.io/ipfs/${result}`
                console.log('ipfs_url',url);

                document.getElementById('ipfs_url').value = url;

                let nft_img = photo.files[0].name; 

                let name = document.getElementById('name').value; 
                
                // let price = document.getElementById('price').value;

                let csm_price = document.getElementById('csm_price').value; //csm value

                let bnb_price = document.getElementById('bnb_price').value;// bnb value

                let price = bnb_price * csm_price;

                let tokens = web3.utils.toWei(price.toString(), 'ether')

                let weiValue = web3.utils.toBN(tokens)

                console.log('price',price);
                console.log('bnb_price',bnb_price);
                console.log('csm_price',csm_price);
                console.log('tokens',tokens);
                console.log('weiValue',weiValue);

                let royalty = document.getElementById('royalty').value;
               
                let descripition = document.getElementById('descripition').value;

                let nft_type = document.getElementById('nft_type').value;

                

                // contract.methods.MintFixedNFT('4545','rty','46','5ytryry',4454,44)
                // contract.methods.MintFixedNFT(name,url,descripition,nft_type,price,royalty)
                contract.methods.MintFixedNFT(name,nft_type,descripition,nft_img,tokens,royalty)
                .send({
                  from: receiverAddress,
                  gas:500000,
                  // value: 5
                  //gasPrice: '210000000'
                }).on('error', function(error){
                    console.log('error',error);
                    toastr.error('Something went wrong');
                    // location.reload();
                }).then( function( info ) {
                    console.log('success ',info);
                    var token_id = info.events.Transfer.returnValues.tokenId;
                    var transactionHash = info.transactionHash;


                    console.log('Nft_name',name);
                    console.log('price',price);
                    console.log('csm_price',csm_price);
                    console.log('bnb_price',bnb_price);
                    console.log('royalty',royalty);
                    console.log('descripition',descripition);
                    console.log('nft_type',nft_type);
                    console.log('transaction_id',transactionHash);
                    console.log('tokenId',token_id);


                    $.ajax({
                        url: "{{ route('nft.add_mint') }}",
                        type: "POST",
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                       },
                       data :{
                           name : name,
                           nft_img : nft_img,
                           img : base64buf,
                           price : price,
                           csm_price : csm_price,
                           bnb_price : bnb_price,
                           royalty : royalty,
                           ipfs_url : url,
                           descripition : descripition,
                           transaction_id : transactionHash,
                           tokenId : token_id,
                       },
                        success: function (response) 
                        {
                            console.log(response);
                             
                            if(response == 200){
                                toastr.success('You mint nft successfully');
                                // var url = "https://anandisha.com/alpha_game_code/public/en/nft/nft_collection";
                                // // $(location).attr('href', url); // Using this
                                // // window.location.replace(url);
                                // window.location = "https://anandisha.com/alpha_game_code/public/en/nft/nft_collection";
                                // window.location.href = 'https://anandisha.com/alpha_game_code/public/en/nft/nft_collection';
                                // window.location.href = "https://www.geeksforgeeks.org/";

                                $(location).prop('href', 'https://anandisha.com/alpha_game_code/public/en/nft/nft_collection')
                                // setTimeout(function(){
                                //     window.location = "https://anandisha.com/alpha_game_code/public/en/nft/nft_collection";
                                // },1000)

                            }else{
                              toastr.error('Something went wrong'); 
                                location.reload();
                            }
                        }
                    });
                      
                });


            })
        }

        const photo = document.getElementById("photo");
        reader.readAsArrayBuffer(photo.files[0]); // Read Provided File

        
    }

   function updateStatus(status) {
      const statusEl = document.getElementById('status');
      statusEl.innerHTML = status;
      console.log(status);
   }

   load();
                
</script>
@endpush
