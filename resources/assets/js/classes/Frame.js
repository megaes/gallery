export default class {
    constructor(id, name, tn_aspect_ratio, caption, tags = [])
    {
        this._id = id;
        this._name = name;
        this._tn_aspect_ratio = tn_aspect_ratio;
        this.caption = caption;
        this.tags = tags;
        this._activity = 0;
        this._load = this._visible = false;
    }

    hasTags(tags)
    {
        let i = tags.length;
        while((--i >= 0) && (this.tags.indexOf(tags[i]) != -1));
        return (i < 0);
    }

    mouseOver(value)
    {
        if(value) {
            this._activity |= 10;
        } else {
            this._activity &= 101;
        }
    }

    focus(value)
    {
        if(value) {
            this._activity |= 100;
        } else {
            this._activity &= 11;
        }
    }

    toggleSelection()
    {
        this._activity ^= 1;
    }

    set select(value)
    {
        this._activity = (this._activity & ~1) | value;
    }

    get select()
    {
        return this._activity & 1;
    }

    get active()
    {
        return this._activity;
    }

    get visible()
    {
        return this._visible;
    }

    set visible(value)
    {
        this._load |= this._visible = value;
    }

    get load()
    {
        return this._load;
    }

    get id()
    {
        return this._id;
    }

    get name()
    {
        return this._name;
    }

    get tn_aspect_ratio()
    {
        return this._tn_aspect_ratio;
    }

}