import DS from 'ember-data';

export default DS.Model.extend({
  title: DS.attr('string'),
  is_completed: DS.attr('number'),
  is_deleted: DS.attr('number')
});
