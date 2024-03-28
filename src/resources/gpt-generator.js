/**
 * Google publisher tag generator
 *
 * @see https://developers.google.com/doubleclick-gpt/reference
 * @see https://support.google.com/dfp_sb/answer/4623874?hl=zh-Hant&ref_topic=4409240
 */

export default {
    /**
     * Ad manager network ID
     */
    _network: 0,

    /**
     * Service enabled
     */
    _enabled: false,

    /**
     * Build slot serial
     */
    _serial: 0,

    /**
     * GPT javascript id
     */
    _gptID: 'gpt-js',

    /**
     * New slot selector
     */
    _selectorClass: 'gpt-new',

    /**
     * Immediately scan slot when ready
     */
    _immediately: true,

    /**
     * Display debug information
     */
    _debug: false,

    /**
     * Load gpt javascript core
     *
     * @returns {default}
     */
    buildCore: function (slotRenderEndedCallback) {
        let self = this;
        googletag.cmd.push(function () {
            // Immediately scan slot
            if (self._immediately) {
                self.scan();
                document.addEventListener('DOMContentLoaded', function () {
                    self.scan();
                });
            }
        });

    },

    /**
     * Build and display slot
     *
     * @param target
     * @returns {default}
     */
    buildSlot: function (target) {
        // Remove selector
        try {
            target.classList.remove(this._selectorClass);
        } catch (e) {}

        // Get attributes
        let attributes;
        attributes = this.extractJson(target);
        if (!attributes) {
            attributes = this.extractAttribute(target);
        }
        if (!attributes) {
            console.error('GPT generator: Invalid attributes', target);
            return this;
        }

        // Prepare
        target.setAttribute('id', attributes.id);
        if (this._debug) {
            console.log('GPT generator: Slot ' + attributes.id, attributes);
        }

        // Build slot service
        let service;
        let mapping;
        try {
            service = googletag.pubads();
            mapping = googletag.sizeMapping();
            for (let targeting in attributes.targeting) {
                service.setTargeting(
                    targeting,
                    attributes.targeting[targeting],
                );
            }
            for (let i = 0; i < attributes.mapping.length; i++) {
                mapping = mapping.addSize(
                    attributes.mapping[i].screen,
                    attributes.mapping[i].list,
                );
            }
        } catch (e) {
            console.error(
                'GPT generator: ' +
                attributes.id +
                ' build failed. ' +
                e.message,
            );
            return this;
        }

        // Display
        try {
            let self = this;
            googletag.cmd.push(function () {
                let slot;
                switch (attributes.type) {
                    case 'oop':
                        slot = googletag
                            .defineOutOfPageSlot(
                                '/' + self._network + '/' + attributes.name,
                                attributes.id,
                            )
                            .addService(service);
                        break;

                    default:
                        slot = googletag
                            .defineSlot(
                                '/' + self._network + '/' + attributes.name,
                                attributes.size,
                                attributes.id,
                            )
                            .defineSizeMapping(mapping.build())
                            .addService(service);
                        break;
                }
                googletag.display(attributes.id);
                googletag.pubads().refresh([slot]);
            });
        } catch (e) {
            console.error(
                'GPT generator: ' +
                attributes.id +
                ' display failed. ' +
                e.message,
            );
            return this;
        }

        return this;
    },

    /**
     * Scan new slot
     *
     * @returns {default}
     */
    scan: function () {
        let self = this;
        if (!this._enabled) {
            setTimeout(function () {
                self.scan();
            }, 100);
            return this;
        }

        let list = document.querySelectorAll('.' + this._selectorClass);
        let i;
        for (i = 0; i < list.length; i++) {
            this.buildSlot(list[i]);
        }
        return this;
    },

    /**
     * Extract attributes from json
     *
     * Element format
     * <div class="gpt-new">
     *   <scr ipt type="application/json">
     *     {
     *       "name": "",
     *       "type": "",
     *       "size": [[0, 0]],
     *       "mapping": [
     *         {
     *           screen: [0, 0],
     *           list: [[0, 0], [0, 0]]
     *         }
     *         {
     *           screen: [1, 0],
     *           list: [[1, 1], [1, 1]]
     *         }
     *       ],
     *       "targeting": {
     *         "author": ["author1", "author2"],
     *         "tag": ["tag1", "tag2"]
     *       }
     *     }
     *   </scr ipt>
     * </div>
     *
     * @param target
     * @returns {boolean|{name}|*}
     */
    extractJson: function (target) {
        let attributes;
        attributes = {
            id: '',
            name: '',
            type: 'general',
            size: [],
            mapping: [],
            targeting: {},
        };

        // Parser
        try {
            let source = JSON.parse(
                target.querySelector('script').textContent.trim(),
            );
            attributes.name = source.hasOwnProperty('name')
                ? source.name
                : attributes.name;
            attributes.type = source.hasOwnProperty('type')
                ? source.type
                : attributes.type;
            attributes.size = source.hasOwnProperty('size')
                ? source.size
                : attributes.size;
            attributes.mapping = source.hasOwnProperty('mapping')
                ? source.mapping
                : attributes.mapping;
            attributes.targeting = source.hasOwnProperty('targeting')
                ? source.targeting
                : attributes.targeting;
        } catch (e) {
            return false;
        }

        return this.validAttribute(attributes);
    },

    /**
     * Extract attributes from element
     *
     * Element format
     * <div
     *   class="gpt-new"
     *   data-name=""
     *   data-type=""
     *   data-size="0,0/0,0"
     *   data-mapping="0,0=0,0/0,0;1,0=1,1/1,1"
     *   data-targeting-author="author1,author2"
     *   data-targeting-tag="tag1,tag2"
     * ></div>
     *
     * @param target
     * @returns {boolean|{name}|*}
     */
    extractAttribute: function (target) {
        let attributes;
        attributes = {
            id: '',
            name: '',
            type: 'general',
            size: [],
            mapping: [],
            targeting: {},
        };

        // Parser
        try {
            let regex_targeting = new RegExp(
                /^data-targeting-([a-z0-9-_.]+)$/i,
            );
            let regex_match;
            for (let i = 0; i < target.attributes.length; i++) {
                switch (target.attributes[i].name) {
                    case 'data-name':
                        attributes.name = target.attributes[i].value;
                        continue;

                    case 'data-type':
                        attributes.type = target.attributes[i].value;
                        continue;

                    case 'data-size':
                        attributes.size = this.extractSize(
                            target.attributes[i].value,
                        );
                        continue;

                    case 'data-mapping':
                        attributes.mapping = this.extractMapping(
                            target.attributes[i].value,
                        );
                        continue;
                }

                regex_match = regex_targeting.exec(target.attributes[i].name);
                if (regex_match) {
                    attributes.targeting[regex_match[1]] = target.attributes[
                        i
                        ].value.split(',');
                }
            }
        } catch (e) {
            return false;
        }

        return this.validAttribute(attributes);
    },

    /**
     * Check attributes and preprocess
     *
     * Attributes:
     *  - name: Require
     *  - type: Optional. Default 'general'. Available: 'general', 'oop'.
     *  - size: Require or mapping exists. Default list from mapping minimum screen.
     *  - mapping: Require or size exists. Default all screen with list from size.
     *  - targeting: Optional.
     *
     * @param attributes
     * @returns {boolean|{name}|*}
     */
    validAttribute: function (attributes) {
        // Slot name
        if (!attributes.name && attributes.name === '') {
            return false;
        }
        this._serial++;
        attributes.id = 'gpt-' + attributes.name + '-' + this._serial;

        // Slot type
        switch (attributes.type) {
            case 'general':
            case 'oop':
                break;

            default:
                attributes.type = 'general';
                break;
        }

        // Size
        switch (attributes.type) {
            case 'general':
                if (
                    attributes.size.length <= 0 &&
                    attributes.mapping.length <= 0
                ) {
                    return false;
                }

                if (attributes.size.length <= 0) {
                    // Default size from mapping
                    try {
                        let min_screen = 0;
                        for (let i = 0; i < attributes.mapping.length; i++) {
                            if (
                                attributes.mapping[i].screen[0] < min_screen ||
                                min_screen === 0
                            ) {
                                attributes.size = attributes.mapping[i].list;
                                min_screen = attributes.mapping[i].screen[0];
                            }
                        }
                    } catch (e) {
                        console.error(
                            'GPT generator: ' +
                            attributes.id +
                            ' default size failed.',
                        );
                        return false;
                    }
                } else {
                    if (Number.isInteger(attributes.size[0])) {
                        attributes.size = [attributes.size];
                    }
                }

                if (attributes.mapping.length <= 0) {
                    // Default mapping from size
                    try {
                        attributes.mapping.push({
                            screen: [0, 0],
                            list: attributes.size,
                        });
                    } catch (e) {
                        console.error(
                            'GPT generator: ' +
                            attributes.id +
                            ' default mapping failed.',
                        );
                        return false;
                    }
                }
                break;
        }

        // Target
        for (let targeting in attributes.targeting) {
            if (attributes.targeting[targeting].length <= 0) {
                delete attributes.targeting[targeting];
                continue;
            }

            for (let i = 0; i < attributes.targeting[targeting].length; i++) {
                if (typeof attributes.targeting[targeting][i] !== 'string') {
                    attributes.targeting[targeting][i] = String(
                        attributes.targeting[targeting][i],
                    );
                }
            }
        }

        return attributes;
    },

    /**
     * Extract mapping list from string
     *
     * Special char:
     *  ; Split different screen mapping
     *  = Split screen size and list
     *  / Split list item
     *  , Split size width and height
     * Full format:
     *  - [Screen width],[Screen height]=[Size width],[Size width]/[Size width],[Size width];[Screen width],[Screen height]=[Size width],[Size width]
     * Example:
     *  - 728,0=970,250/300,250;0,0=300,250
     *
     * @param source
     * @returns {[]}
     */
    extractMapping: function (source) {
        let mapping = [];
        let regex_size = new RegExp(/^[0-9]+,[0-9]+$/i);

        try {
            let region = source.split(';');
            for (let i = 0; i < region.length; i++) {
                let screen;
                let list = [];

                // Screen size
                let frame = region[i].split('=');
                if (!regex_size.test(frame[0])) {
                    continue;
                }
                frame[0] = frame[0].split(',');
                screen = [parseInt(frame[0][0], 10), parseInt(frame[0][1], 10)];

                // Slot size
                list = this.extractSize(frame[1]);

                if (list.length > 0) {
                    mapping.push({screen: screen, list: list});
                }
            }
        } catch (e) {
            mapping = [];
        }

        return mapping;
    },

    /**
     * Extract size list from string
     *
     * Special char:
     *  / Split list item
     *  , Split size width and height
     * Full format:
     *  - [Width],[Height]/[Width],[Height]
     * Example:
     *  - 970,250/300,250
     *
     * @param source
     * @returns {[]}
     */
    extractSize: function (source) {
        let list = [];
        let regex_size = new RegExp(/^[0-9]+,[0-9]+$/i);

        try {
            source = source.split('/');
            for (let i = 0; i < source.length; i++) {
                if (!regex_size.test(source[i])) {
                    continue;
                }
                source[i] = source[i].split(',');
                list.push([
                    parseInt(source[i][0], 10),
                    parseInt(source[i][1], 10),
                ]);
            }
        } catch (e) {
            list = [];
        }

        return list;
    },
};
