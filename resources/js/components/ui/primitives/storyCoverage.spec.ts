import { expect, it } from 'vitest';

const components = import.meta.glob('./**/*.vue');
const stories = import.meta.glob('./**/*.stories.ts');

it('should provide a same-name colocated story for every primitive', () => {
    Object.keys(components).forEach((componentPath) => {
        const storyPath = componentPath.replace(/\.vue$/, '.stories.ts');
        expect(stories, `${componentPath} is missing ${storyPath}`).toHaveProperty(
            storyPath,
        );
    });
});
