# Contribute to challenge-stack

This document describes how to contribute to projet_git.

This project is a community effort. We welcome contributions of all kinds from anyone willing to work in good faith with other contributors and the community. No contribution is too small and all contributions are valued.

Thanks! :heart:

<details>
<summary>Ways to contribute :mag:</summary>
<br>

To contribute to projet_git, you can:
- Report a bug
- Suggest a new feature
- Build a new feature
- Write or update documentation
- Fix a bug
- Add tests
- Help triage issues
</details>

<br>

<details>
<summary>Report a bug :bug:</summary>
<br>

This section guides you through submitting a bug report for projet_git. Following these guidelines helps maintainers and the community understand your report :pencil:, reproduce the behavior :computer: :computer:, and find related reports :mag_right:.

Before creating bug reports, please check [this list](#before-submitting-a-bug-report) as you might find out that you don't need to create one. When you are creating a bug report, please [include as many details as possible](#how-do-i-submit-a-good-bug-report).

### Before reporting a bug

Please check the following list:

- **Ensure the bug was not already reported** by searching on GitHub under [**Issues**](https://github.com/sDev67/projet_git/issues). If the bug has already been reported **and the issue is still open**, add a comment to the existing issue instead of opening a new one.

**Note:** If you find a **Closed** issue that seems similar to what you're experiencing, open a new issue and include a link to the original issue in the body of your new one.

### Submitting A Bug Report

To report a bug, [open a new issue](https://github.com/sDev67/projet_git/issues/new?assignees=&labels=bug&template=bug_report.yml&title=%5BBug%5D%3A+), and be sure to include as many details as possible, using the template.

**Note:** Minor changes such as fixing a typo can but do not need an open issue.

If you also want to fix the bug, submit a [pull request](#pull-requests) and reference the issue.

</details>

<br>

<details>
<summary>Suggest a new feature or topic for the wiki :bulb:</summary>
<br>

This section guides you through submitting a suggestion for a new feature or topic for the wiki. Following these guidelines helps maintainers and the community collaborate to find the best possible way forward with your suggestion :pencil:.

Before creating a suggestion, please check [this list](#before-submitting-a-new-feature) as you might find out that you don't need to create one. When you are creating a suggestion, please include as many details as possible.

### Before suggesting a new feature

**Ensure the feature or topic has not already been suggested** by searching on GitHub under [**Issues**](https://github.com/sDev67/projet_git/issues).

### Suggesting a new feature or topic

To suggest a new feature/topic, [open a new issue](https://github.com/sDev67/projet_git/issues/new?assignees=&labels=feature&template=feature_request.yml&title=%5BFEATURE%5D%3A+), using the suggestion template.

</details>

<br>

<details>
<summary>Add a new feature or topic :hammer:</summary>
<br>

This section guides you through adding a new feature or topic. Following these guidelines helps give your feature/topic the best chance of being approved and merged.

### Before adding a new feature/topic

Check if there is already an [open issue](https://github.com/sDev67/projet_git/issues) or [pull request (PR)](https://github.com/sDev67/projet_git/issues/pulls), related to your feature/topic.

Otherwise, your feature may not be approved at all.

### Adding a new feature/topic

To build a new feature/topic, check out a new branch based on the `develop` branch.

</details>

<br>

<details>
<summary>Pull requests :mega:</summary>
<br>

This section guides you through submitting a pull request (PR). Following these guidelines helps give your PR the best chance of being approved and merged.

### Before submitting a pull request

Before submitting a pull request, please follow these steps to have your contribution considered by the maintainers:

- A pull request should have exactly one concern (for example one feature or one bug). If a PR addresses more than one concern, it should be split into two or more PRs.

- A pull request can be merged only if it references an open issue

  **Note:** You don't need to open an issue for minor changes such as typos, but you can if you want.

- All code should be well tested

### Submitting a pull request

The following is a short overview on how to submit a pull request:
1. Fork the projet_git repository and create your branch from `develop`.
2. Create a pull request against the `develop` branch.
3. If the pull request is approved and merged, you can safely delete your branch.

**Note:** Reviewers may ask you to complete additional work, tests, or other changes before your pull request can be approved and merged.

</details>

<br>

<details>
<summary>Commits :box:</summary>
<br>

This section guides you through writing good commit messages. Following these guidelines helps give your commit the best chance of being approved and merged.

### Before writing a commit

Before writing a commit, please follow these steps to have your contribution considered by the maintainers:
- A commit should have exactly one concern (for example one feature or one bug). If a commit addresses more than one concern, it should be split into two or more commits.
- All code should be well tested
- All commits should be well documented
- All commits should be well formatted
- All commits should be well linted
- All commits should be well signed
- All commit messages should be written in English

### Making a commit

Here is the only format of commit message that is acceptable:

- An hash tag (#) followed by the issue number
- A space
- A colon (:)
- Another space
- A short description of the commit
- A dot (.)

**All commit messages that do not follow this format will be rejected by the `commit-msg` hook.**

Here is an example of a commit message:

```git
#123 : Add a new feature.
```

</details>


- Les branches doivent être nommées de la manière suivante : `type/nom_de_la_branche` où `type` est le type de la branche (feature, bugfix, hotfix, chore, docs, refactor, style, test) et `nom_de_la_branche` est le nom de la branche.

- Les commits doivent être nommés de la manière suivante : `type: description` où `type` est le type du commit (feat, fix, docs, style, refactor, test, chore) et `description` est la description du commit.

- Les pull requests doivent être nommées de la manière suivante : `type: description` où `type` est le type de la pull request (feat, fix, docs, style, refactor, test, chore) et `description` est la description de la pull request.

- Les issues doivent être nommées de la manière suivante : `type: description` où `type` est le type de l'issue (feat, fix, docs, style, refactor, test, chore) et `description` est la description de l'issue.

- Les commits doivent être signés de tous les membres et sur tous les commits.

- Les pull requests doivent être validées par au moins 2 membres du groupe.

- Les pull requests doivent être mergées par le propriétaire de la branche.

- Les pull requests doivent être mergées dans la branche `develop`.

- Les pull requests doivent être mergées après avoir été validées.