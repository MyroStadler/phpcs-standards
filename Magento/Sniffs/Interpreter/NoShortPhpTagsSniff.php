<?php
class Magento_Sniffs_Interpreter_NoShortPhpTagsSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array(T_INLINE_HTML);

    }


    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $openTag = $tokens[$stackPtr];
        $openTagContent = trim($openTag['content']);
        if ($openTagContent == '<?') {
            $error = 'Short PHP opening tag used; expected "<?php" but found "%s"';
            $data  = array($openTag['content']);
            $fix   = $phpcsFile->addFixableError($error, $stackPtr, 'Found', $data);
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken($stackPtr, '<?php');
            }
        }

    }


}