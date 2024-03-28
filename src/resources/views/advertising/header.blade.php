<script>
    window.pbjs = window.pbjs || {que: []};
    window.googletag = window.googletag || {cmd: []};
</script>
@if (isset($flux_core))
    <script async src="{{ $flux_core }}"></script>
@endif
<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
<script>
    window.fluxtag = {
        readyBids: {prebid: false, amazon: false, google: false},
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
                        pbjs.que.push(function () { pbjs.setTargetingForGPTAsync(); });
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
                    var readyBids = {amazon: false, google: false, prebid: false};
                    var definedSlots = [];
                    var adsInfo = {
                        gpt: {slots: [], displayDivIds: []},
                        aps: {slots: [], divIds: []},
                        pb: {divIds: []},
                    };
                    var getSizeList = function (width, height, sizeMappings) {
                        const sizeMapping = sizeMappings.filter(function (mappingObject) {
                            return mappingObject[0][0] <= width && mappingObject[0][1] <= height;
                        }).reduce(function (a, b) {
                            return (Math.abs(b[0][0] - width) <= Math.abs(a[0][0] - width) && Math.abs(b[0][1] - height) <= Math.abs(a[0][1] - height)) ? b : a;
                        });
                        if (!sizeMapping[1].length) {
                            sizeMapping[1].push([]);
                        }
                        return sizeMapping[1];
                    };
                    googletag.pubads().getSlots().forEach(function (slot) {
                        definedSlots[slot.getSlotElementId()] = slot;
                    });

                    lines.forEach(function (line) {
                        var divId = line.divId;
                        adsInfo.pb.divIds.push(divId);
                        refreshLines.push({code: line.gpt.unitCode, id: divId});
                        if (definedSlots[divId]) {
                            adsInfo.gpt.slots.push(definedSlots[divId]);
                        } else {
                            var slot = googletag.defineSlot(line.gpt.unitCode, line.gpt.sizes, divId).addService(googletag.pubads());
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
                    if (adsInfo.aps.slots.length === 0) {
                        readyBids.amazon = true;
                    }
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
                    var apsCallback = function () {
                        readyBids.amazon = true;
                        adServerSend();
                    };
                    var pbCallback = function () {
                        readyBids.prebid = true;
                        adServerSend();
                    };
                    setTimeout(function () {
                        readyBids.amazon = true;
                        readyBids.prebid = true;
                        adServerSend();
                    }, failSafeTimeout);
                    return {aps: {slots: adsInfo.aps.slots, callback: apsCallback}, prebid: {callback: pbCallback}};
                })();
                if (!!(window.pbFlux) && window.pbFlux.refresh && fluxtag.isFn(window.pbFlux.refresh)) {
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
                    window.apstag.fetchBids({
                        slots: params.aps.slots,
                        timeout: bidRequestTimeout,
                    }, function (bids) { params.aps.callback(); });
                } else {
                    params.aps.callback();
                }
            });
        },
    };
</script>
<script>
    googletag.cmd.push(function () {
        googletag.pubads().enableSingleRequest();
        googletag.pubads().disableInitialLoad();
        googletag.pubads().enableAsyncRendering();
        googletag.pubads().collapseEmptyDivs();
        // googletag.pubads().addEventListener('slotRenderEnded', slotRenderEndedCallback);
        googletag.enableServices();
    });
</script>
