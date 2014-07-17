'use strict';

describe("AjaxForm", function() {
    it("can be constructed and used as an object", function() {
        var scope = new Scope();
        scope.setAProperty(1);

        expect(scope.getAProperty()).toBe(1);
    })
});