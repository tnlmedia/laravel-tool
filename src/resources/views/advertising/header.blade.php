<script type="text/javascript">
    window.pbjs = window.pbjs || {que: []};
    window.googletag = window.googletag || {cmd: []};
</script>
@if (isset($flux_core))
    <script async src="{{ $flux_core }}"></script>
@endif
<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
<script type="text/javascript">
    window.fluxtag = {
        readyBids: {
            prebid: false,
            amazon: false,
            google: false,
        },
        failSafeTimeout: 3000,
        isFn: function (object) {
            var _t = 'Function';
            var toString = Object.prototype.toString;
            return toString.call(object) === '[object ' + _t + ']';
        },
        launchAdServer: function () {
            if (!fluxtag.readyBids.prebid || !fluxtag.readyBids.amazon) {
                return;
            }
            fluxtag.requestAdServer();
        },
        requestAdServer: function () {
            if (!fluxtag.readyBids.google) {
                fluxtag.readyBids.google = true;
                googletag.cmd.push(function () {
                    if (!!(pbjs.setTargetingForGPTAsync) && fluxtag.isFn(pbjs.setTargetingForGPTAsync)) {
                        pbjs.que.push(function () {
                            pbjs.setTargetingForGPTAsync();
                        });
                    }
                    googletag.pubads().refresh();
                });
            }
        },
        renderAds: function (lines, failSafeTimeout) {
            googletag.cmd.push(function () {
                var failSafeTimeout = failSafeTimeout || window.fluxtag.failSafeTimeout;
                var bidRequestTimeout = (failSafeTimeout - 500) > 0 ? failSafeTimeout - 500 : failSafeTimeout;
                var refreshLines = [];
                var params = (function () {
                    // GAMを呼び出したかを確認にするフラグ 標記以查看是否叫GAM
                    var readyBids = {
                        amazon: false,
                        google: false,
                        prebid: false,
                    };
                    var definedSlots = [];
                    var adsInfo = {
                        gpt: {
                            slots: [],
                            displayDivIds: [],
                        },
                        aps: {
                            slots: [],
                            divIds: [],
                        },
                        pb: {
                            divIds: [],
                        },
                    };
                    // window幅に合わせてサイズ一覧を返す関数
                    // 根據其寬度返回大小列表的函數
                    var getSizeList = function (width, height, sizeMappings) {
                        // サイズマッピングをfilterして、reduce関数で近い方のサイズを取得
                        // filter大小映射,使用reduce函數可以更近的大小
                        const sizeMapping = sizeMappings.filter(function (mappingObject) {
                            return mappingObject[0][0] <= width && mappingObject[0][1] <= height;
                        }).reduce(function (a, b) {
                            return (Math.abs(b[0][0] - width) <= Math.abs(a[0][0] - width) && Math.abs(b[0][1] - height) <= Math.abs(a[0][1] - height)) ? b : a;
                        });
                        // 取得したサイズマッピングのサイズ一覧が空なら空の配列を追加する
                        // 如果獲取的大小映射的大小列表為空,請添加一個空數組

                        if (!sizeMapping[1].length) {
                            sizeMapping[1].push([]);
                        }
                        // 取得したサイズマッピングのサイズ一覧を返す
                        // 返回已獲取尺寸映射的大小列表
                        return sizeMapping[1];
                    };
                    googletag.pubads().getSlots().forEach(function (slot) {
                        // 既にdefineSlotされていた場合
                        // 如果您已經定義插槽
                        definedSlots[slot.getSlotElementId()] = slot;
                    });

                    lines.forEach(function (line) {
                        var divId = line.divId;

                        adsInfo.pb.divIds.push(divId);

                        refreshLines.push({
                            code: line.gpt.unitCode,
                            id: divId,
                        });

                        if (definedSlots[divId]) {
                            adsInfo.gpt.slots.push(definedSlots[divId]);
                        } else {
                            var slot = googletag.defineSlot(line.gpt.unitCode, line.gpt.sizes, divId)
                                .addService(googletag.pubads());

                            if (line.gpt.sizeMapping && line.gpt.sizeMapping.length > 0) {
                                var sizeMapping = googletag.sizeMapping();
                                line.gpt.sizeMapping.forEach(function (size) {
                                    sizeMapping.addSize(size[0], size[1]);
                                });
                                slot.defineSizeMapping(sizeMapping.build());
                            }
                            if (line.gpt.keyValues && line.gpt.keyValues.length > 0) {
                                line.gpt.keyValues.forEach(function (param) {
                                    slot.setTargeting(param.key, param.value);
                                });
                            }
                            adsInfo.gpt.slots.push(slot);
                            adsInfo.gpt.displayDivIds.push(divId);
                        }

                        // TAM並走枠の場合
                        // 對於TAM平行線
                        if (!!line.aps) {
                            if (line.gpt.sizeMapping && line.gpt.sizeMapping.length > 0) {
                                line.aps.sizes = getSizeList(window.innerWidth, window.innerHeight, line.gpt.sizeMapping);
                            }
                            adsInfo.aps.slots.push({
                                slotID: divId,
                                slotName: line.aps.slotName,
                                sizes: line.aps.sizes,
                            });
                            adsInfo.aps.divIds.push(divId);
                        }
                    });
                    // APSの枠がない場合
                    // 如果沒有APS框架
                    if (adsInfo.aps.slots.length === 0) {
                        readyBids.amazon = true;
                    }
                    // Prebid、APSでオークション後に起動する関数 (GAMコール、広告Display)
                    // Prebid,使用APS拍賣後開始的功能 (GAM通話,廣告顯示)
                    var adServerSend = function () {
                        if (!readyBids.amazon || !readyBids.prebid) {
                            return;
                        }
                        if (!readyBids.google) {
                            readyBids.google = true;
                            adsInfo.gpt.displayDivIds.forEach(function (divId) {
                                googletag.display(divId);
                            });
                            if (!!(pbjs.setTargetingForGPTAsync) && fluxtag.isFn(pbjs.setTargetingForGPTAsync)) {
                                pbjs.que.push(function () {
                                    pbjs.setTargetingForGPTAsync(adsInfo.pb.divIds);
                                });
                            }
                            if (adsInfo.aps.slots.length > 0 && !!(window.apstag) && fluxtag.isFn(window.apstag.fetchBids)) {
                                window.apstag.setDisplayBids(adsInfo.aps.divIds);
                            }
                            googletag.pubads().refresh(adsInfo.gpt.slots);
                        }
                    };
                    // APSオークション後に起動する関数
                    // APS拍賣後開始的功能
                    var apsCallback = function () {
                        readyBids.amazon = true;
                        adServerSend();
                    };
                    // Prebidオークション後に起動する関数
                    // Prebid拍賣後開始的功能
                    var pbCallback = function () {
                        readyBids.prebid = true;
                        adServerSend();
                    };
                    // もしtimeout以内にPrebidが動作できなかった場合、最終的にGAMをコール
                    // 如果Prebid無法在超時時間內工作,請最終致電GAM
                    setTimeout(function () {
                        readyBids.amazon = true;
                        readyBids.prebid = true;
                        adServerSend();
                    }, failSafeTimeout);

                    return {
                        aps: {
                            slots: adsInfo.aps.slots,
                            callback: apsCallback,
                        },
                        prebid: {
                            callback: pbCallback,
                        },
                    };
                })();

                if (!!(window.pbFlux) && window.pbFlux.refresh && fluxtag.isFn(window.pbFlux.refresh)) {
                    // Prebid呼び出し
                    // Prebid呼叫
                    pbjs.que.push(function () {
                        window.pbFlux.refresh({
                            lines: refreshLines,
                            callback: params.prebid.callback,
                            timeout: bidRequestTimeout,
                        });
                    });
                } else {
                    params.prebid.callback();
                }

                if (params.aps.slots.length > 0 && !!(window.apstag) && fluxtag.isFn(window.apstag.fetchBids)) {
                    // APS呼び出し
                    // APS呼叫
                    window.apstag.fetchBids({
                        slots: params.aps.slots,
                        timeout: bidRequestTimeout,
                    }, function (bids) {
                        params.aps.callback();
                    });
                } else {
                    params.aps.callback();
                }
            });
        },
    };
</script>
<script>
    googletag.cmd.push(function () {
        // Infinite scroll requires SRA
        googletag.pubads().enableSingleRequest();

        // Disables requests for ads on page load, but allows ads to be requested with a googletag.pubads().refresh() call.
        googletag.pubads().disableInitialLoad();

        // Enables async rendering mode to enable non-blocking fetching and rendering of ads.
        googletag.pubads().enableAsyncRendering();

        // Collapse all empty divs
        googletag.pubads().collapseEmptyDivs();

        // Adding an event listener for the PubAdsService.
        googletag.pubads().addEventListener('slotRenderEnded', slotRenderEndedCallback);

        // Enable services
        googletag.enableServices();
    });
</script>
